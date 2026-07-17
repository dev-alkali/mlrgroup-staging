<?php
defined('ABSPATH') || exit;

add_action('wp_ajax_search_portfolio',        'mlr_search_portfolio_ajax');
add_action('wp_ajax_nopriv_search_portfolio', 'mlr_search_portfolio_ajax');

/**
 * AJAX handler for the "Get inspired" live search.
 *
 * Returns rendered portfolio cards ordered by the weighted relevance helper
 * (item name > item code > category). Handles both the initial results and
 * subsequent infinite-scroll pages via the `paged` param.
 */
function mlr_search_portfolio_ajax() {
    check_ajax_referer('portfolio_search_nonce', 'security');

    $search   = isset($_POST['search'])  ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $term_id  = isset($_POST['term_id']) ? absint($_POST['term_id']) : 0;
    $paged    = isset($_POST['paged'])   ? max(1, absint($_POST['paged'])) : 1;
    $per_page = 12;

    // Require a minimum length so a single character doesn't return the catalog.
    if (function_exists('mb_strlen') ? mb_strlen($search) < 2 : strlen($search) < 2) {
        wp_send_json_success(array(
            'html'     => '',
            'has_more' => false,
            'found'    => 0,
            'empty'    => true,
        ));
    }

    $ids = mlr_portfolio_search_ordered_ids($search);

    if (empty($ids)) {
        wp_send_json_success(array(
            'html'     => '',
            'has_more' => false,
            'found'    => 0,
            'empty'    => true,
        ));
    }

    $args = array(
        'post_type'              => 'portfolio',
        'post_status'            => 'publish',
        'posts_per_page'         => $per_page,
        'paged'                  => $paged,
        'post__in'               => $ids,
        'orderby'                => 'post__in',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
    );

    // Optional scope to a category (not used on /work/, but supported).
    if ($term_id > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio-category',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }

    $query = new WP_Query($args);

    if (! $query->have_posts()) {
        wp_send_json_success(array(
            'html'     => '',
            'has_more' => false,
            'found'    => 0,
            'empty'    => true,
        ));
    }

    ob_start();
    while ($query->have_posts()) {
        $query->the_post();
        $post_id   = get_the_ID();
        $image_url = has_post_thumbnail()
            ? get_the_post_thumbnail_url($post_id, 'full')
            : '/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg';

        get_template_part('template-parts/portfolio/card', null, array(
            'post_id'   => $post_id,
            'image_url' => $image_url,
        ));
    }
    $html = ob_get_clean();

    wp_reset_postdata();

    wp_send_json_success(array(
        'html'     => $html,
        'has_more' => $query->max_num_pages > $paged,
        'found'    => (int) $query->found_posts,
        'empty'    => false,
    ));
}
