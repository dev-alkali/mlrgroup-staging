<?php
add_action( 'wp_ajax_load_more_portfolio',        'load_more_portfolio_ajax' );
add_action( 'wp_ajax_nopriv_load_more_portfolio', 'load_more_portfolio_ajax' );

function load_more_portfolio_ajax() {

    check_ajax_referer( 'portfolio_load_nonce', 'security' );

    $term_id  = isset( $_POST['term_id'] ) ? absint( $_POST['term_id'] ) : 0;
    $paged    = isset( $_POST['paged'] )   ? absint( $_POST['paged'] )   : 2;
    $per_page = 1;

 
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    );

    if ( $term_id > 0 ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio-category',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
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
            : '';
        $plus_icon = get_template_directory_uri() . '/assets/imgs/plus-black.svg';
        ?>
        <article class="gallery-card group flex flex-col items-start gap-3">
            <div
                class="card-image-wrap relative overflow-hidden aspect-[333.33/360] w-full"
                style="background-image: url('<?= esc_url( $image_url ); ?>'); background-position: 50% 50%; background-size: cover; background-repeat: no-repeat;"
            >
                <div class="card-overlay absolute inset-0 [background:linear-gradient(312deg,rgba(0,0,0,0.82)_0%,rgba(253,67,56,0.82)_100%)] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-2 px-6">

                    <button
                        type="button"
                        data-item-id="<?= esc_attr( $post_id ); ?>"
                        class="view-inquery bg-black flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors translate-y-3 card-btn-transition"
                    >
                        <span class="font-heading font-medium text-white text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap">
                            <?= esc_html__( 'QUICK VIEW', 'your-theme-textdomain' ); ?>
                        </span>
                    </button>

                    <button
                        type="button"
                        data-item-id="<?= esc_attr( $post_id ); ?>"
                        class="add-inquiry bg-white flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#262626] transition-colors translate-y-3 card-btn-transition"
                    >
                        <span class="font-heading font-semibold flex justify-center items-center text-neutral-800 text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap">
                            <img
                                class="h-[14.3px] w-[14.3px] mt-[-2px] mr-[8px]"
                                src="<?= esc_url( $plus_icon ); ?>"
                                alt=""
                                aria-hidden="true"
                            >
                            <?= esc_html__( 'ADD TO INQUIRY LIST', 'your-theme-textdomain' ); ?>
                        </span>
                    </button>

                </div>
            </div>
        </article>
        <?php
    }
    $html = ob_get_clean();

    wp_reset_postdata();

    wp_send_json_success( array(
        'html'     => $html,
        'has_more' => $query->max_num_pages > $paged,
    ) );
}