
<?php
add_action('rest_api_init', function () {
    register_rest_route('mrlgroup/v1', '/cpt-item/(?P<id>\d+)', [
        'methods'             => 'GET',
        'callback'            => 'get_cpt_popup_data',
        'permission_callback' => '__return_true', // or add auth check
        'args'                => [
            'id' => [
                'validate_callback' => fn($v) => is_numeric($v) && (int)$v > 0,
                'sanitize_callback' => fn($v) => absint($v),
            ],
        ],
    ]);
});

function get_cpt_popup_data(WP_REST_Request $request)
{
    $id   = (int) $request['id'];
    $post = get_post($id);

    if (!$post || $post->post_type !== 'portfolio') {
        return new WP_Error('not_found', 'Not found', ['status' => 404]);
    }
    $terms = get_the_terms($id, 'portfolio-category');
    $categories = [];


    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $categories[] = [
                'term_id' => $term->term_id,
                'name'    => wp_specialchars_decode($term->name, ENT_QUOTES),
            ];
        }
    }

    $thumbnail_url = get_the_post_thumbnail_url($id, 'large');
    $thumbnail_id  = get_post_thumbnail_id($id);
    $thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';

    $tooltip_text = get_field('tooltip_description', $id);

    if (!$tooltip_text) {
        $tooltip_text = '';
    }

    $safe_tooltip = wp_kses($tooltip_text, ['br' => []]);

    return [
        'id'                 => $id,
        'title'              => sanitize_text_field(get_the_title($id)),
        'content'            => $safe_tooltip,
        'portfolio_category' => $categories,
        'featured_image'     => [
            'url' => $thumbnail_url ?: null,
            'alt' => $thumbnail_alt,
        ],
    ];
}
