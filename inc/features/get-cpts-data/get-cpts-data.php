<?php
add_action('rest_api_init', function () {
   register_rest_route('mrlgroup/v1', '/cpt-items', [
      'methods'             => 'GET',
      'callback'            => 'get_multiple_cpt_items_data',
      'permission_callback' => '__return_true',
      'args'                => [
         'ids' => [
            'required'          => true,
            'validate_callback' => function ($param) {
               // Validate format
               if (!preg_match('/^(\d+,)*\d+$/', $param)) {
                  return false;
               }
               // Enforce server-side item cap
               $ids = explode(',', $param);
               return count($ids) <= 50; // mirror your JS MAX_ITEMS
            },
            'sanitize_callback' => function ($param) {
               // Return cleaned string; intval casting happens later
               return preg_replace('/[^0-9,]/', '', $param);
            },
         ],
      ],
   ]);
});

function get_multiple_cpt_items_data(WP_REST_Request $request)
{

   $ids_param = $request->get_param('ids');
   $ids_array = array_map('intval', explode(',', $ids_param));
   if (count($ids_array) > 50) {
      return new WP_Error(
          'too_many_ids',
          'A maximum of 50 IDs may be requested at once.',
          ['status' => 400]
      );
  }
   $results = [];

   foreach ($ids_array as $id) {
      $post = get_post($id);

      // Skip if post doesn't exist or isn't a portfolio item
      if (!$post || $post->post_type !== 'portfolio') {
         continue;
      }

      $terms = get_the_terms($id, 'portfolio-category');
      $categories = [];



      $thumbnail_url = get_the_post_thumbnail_url($id, 'large');
      $thumbnail_id  = get_post_thumbnail_id($id);
      $safe_url = null;
      if ($thumbnail_url) {
         $sanitized = esc_url_raw($thumbnail_url);
         // Reject anything that isn't http/https after sanitization
         $scheme = parse_url($sanitized, PHP_URL_SCHEME);
         if (in_array($scheme, ['http', 'https'], true)) {
            $safe_url = $sanitized;
         }
      }

      $thumbnail_alt = $thumbnail_id
         ? sanitize_text_field(
            get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true)
         )
         : '';
      // Push formatted data into our results array
      $results[] = [
         'id'                 => $id,
         'item_code'          => (string) ( get_field('item_code', $id) ?: '' ),
         'title'              => sanitize_text_field(
            html_entity_decode(get_the_title($id), ENT_QUOTES | ENT_HTML5, 'UTF-8')
         ),
         'featured_image'     => [
            'url' => $safe_url ?: null,
            'alt' => $thumbnail_alt,
         ],
      ];
   }

   // Return the array of objects
   return rest_ensure_response($results);
}
