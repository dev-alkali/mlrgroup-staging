<?php
defined('ABSPATH') || exit;

add_action('rest_api_init', function () {
    register_rest_field('case-studies', 'acf_display_title', [
        'get_callback' => function (array $post_arr) {
            $id = (int) $post_arr['id'];
            if (function_exists('get_field')) {
                $acf_title = get_field('custom_single_page_title', $id);
                if (!empty($acf_title)) {
                    return sanitize_text_field($acf_title);
                }
            }
            return sanitize_text_field(get_the_title($id));
        },
        'schema' => [
            'type'        => 'string',
            'description' => 'Display title: ACF custom_single_page_title if set, otherwise the post title.',
            'context'     => ['view'],
        ],
    ]);
});
