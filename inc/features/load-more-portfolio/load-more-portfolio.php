<?php
add_action( 'wp_ajax_load_more_portfolio',        'load_more_portfolio_ajax' );
add_action( 'wp_ajax_nopriv_load_more_portfolio', 'load_more_portfolio_ajax' );

function load_more_portfolio_ajax() {

    check_ajax_referer( 'portfolio_load_nonce', 'security' );

    $term_id  = isset( $_POST['term_id'] ) ? absint( $_POST['term_id'] ) : 0;
    $paged    = isset( $_POST['paged'] )   ? absint( $_POST['paged'] )   : 2;
    $per_page = 12;

 
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    );

    $tax_query = array();

    if ( $term_id > 0 ) {
        $tax_query[] = array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'term_id',
            'terms'    => $term_id,
        );
    }

    // Keep featured items out of the load-more grid so they don't repeat the Featured Items section.
    // Child-only categories don't show a Featured Items section, so include them in the regular grid.
    $featured_term = get_term_by( 'slug', 'featured-items', 'portfolio-category' );
    if ( mlr_portfolio_show_featured_section( $term_id ) && $featured_term && ! is_wp_error( $featured_term ) && $term_id !== (int) $featured_term->term_id ) {
        $tax_query[] = array(
            'taxonomy' => 'portfolio-category',
            'field'    => 'term_id',
            'terms'    => (int) $featured_term->term_id,
            'operator' => 'NOT IN',
        );
    }

    if ( ! empty( $tax_query ) ) {
        if ( count( $tax_query ) > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        wp_send_json_success( array(
            'html'     => '',
            'has_more' => false,
        ) );
    }


    ob_start();
    while ( $query->have_posts() ) {
        $query->the_post();

       
        $post_id   = get_the_ID();
        $image_url = has_post_thumbnail()
            ? get_the_post_thumbnail_url( $post_id, 'full' )
            : '/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg';

        get_template_part( 'template-parts/portfolio/card', null, array(
            'post_id'   => $post_id,
            'image_url' => $image_url,
        ) );
    }
    $html = ob_get_clean();

    wp_reset_postdata();

    wp_send_json_success( array(
        'html'     => $html,
        'has_more' => $query->max_num_pages > $paged,
    ) );
}