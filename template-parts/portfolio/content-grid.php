<?php
$taxonomy = 'portfolio-category';
$current_term = get_queried_object();
$term_id = isset($current_term->term_id) ? absint($current_term->term_id) : 0;
$show_featured_section = mlr_portfolio_show_featured_section($term_id);
?>

<div class="flex flex-col items-start flex-1 min-w-0 justify-center w-full md:w-auto">
    <div class="flex items-center justify-end w-full"></div>

    <div class="w-full">
        <?php
        $featured_term  = get_term_by('slug', 'featured-items', $taxonomy);
        $featured_query = null;

        if ($show_featured_section && $featured_term && ! is_wp_error($featured_term)) {
            $featured_args = array(
                'post_type'      => 'portfolio',
                'posts_per_page' => 24,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            if ($term_id > 0 && $term_id !== (int) $featured_term->term_id) {
                $featured_args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => (int) $featured_term->term_id,
                    ),
                );
            } else {
                $featured_args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => (int) $featured_term->term_id,
                    ),
                );
            }

            $featured_query = new WP_Query($featured_args);
        }

        $has_featured = $show_featured_section
            && ($featured_query instanceof WP_Query)
            && $featured_query->have_posts();
        ?>

        <?php if ($has_featured) : ?>
            <h1 id="portfolio-featured-heading" class="font-[Poppins] font-bold text-[#262626] tracking-[-0.02em] text-[24px] md:text-[32px] leading-[1.2] mb-[20px] md:mb-[28px]">Featured Items</h1>
        <?php endif; ?>

        <p id="portfolio-search-status" class="hidden w-full mb-[20px] md:mb-[28px] font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252]" aria-live="polite"></p>

        <div id="portfolio-grid" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 w-full gap-[10px] md:gap-0">
            <?php
            if ($has_featured) :
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    $post_id = get_the_ID();
                    $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'full') : '/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg';
                    get_template_part('template-parts/portfolio/card', null, array(
                        'post_id'   => $post_id,
                        'image_url' => $image_url,
                    ));
                endwhile;
                wp_reset_postdata();
            endif;

            $query_args = array(
                'post_type'      => 'portfolio',
                'posts_per_page' => 12,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            );

            $grid_tax_query = array();

            if ($term_id > 0) {
                $grid_tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                );
            }

            // Exclude items already shown in the Featured Items section above so they don't repeat.
            if ($show_featured_section && $featured_term && ! is_wp_error($featured_term) && $term_id !== (int) $featured_term->term_id) {
                $grid_tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => (int) $featured_term->term_id,
                    'operator' => 'NOT IN',
                );
            }

            if (! empty($grid_tax_query)) {
                if (count($grid_tax_query) > 1) {
                    $grid_tax_query['relation'] = 'AND';
                }
                $query_args['tax_query'] = $grid_tax_query;
            }

            $portfolio_query = new WP_Query($query_args);

            // Thin gray line between Featured Items and the non-curated items.
            if ($has_featured && $portfolio_query->have_posts()) : ?>
                <div class="col-span-full border-t border-[#CCCCCC] my-[20px] md:my-[28px]" aria-hidden="true"></div>
            <?php endif;

            if ($portfolio_query->have_posts()) :
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    $post_id = get_the_ID();
                    $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'full') : '/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg';
                    get_template_part('template-parts/portfolio/card', null, array(
                        'post_id'   => $post_id,
                        'image_url' => $image_url,
                    ));
                endwhile;
            endif;
            ?>
        </div>

        <?php if ($portfolio_query->max_num_pages > 1) : ?>
            <div
                id="portfolio-infinite-root"
                data-term="<?= esc_attr($term_id); ?>"
                data-current-page="1"
                data-max-pages="<?= esc_attr($portfolio_query->max_num_pages); ?>"
                class="py-[20px]"
            >
                <p id="portfolio-loading-more" class="hidden text-center font-heading font-semibold text-[#fd4338] text-base tracking-[0] leading-6" aria-live="polite">LOADING...</p>
                <div id="portfolio-infinite-sentinel" class="h-px w-full pointer-events-none" aria-hidden="true"></div>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>


    <?php
        $term = get_queried_object(); 
        ?>
        <?php if ( !empty($term->description) ) :
            $heading_tag = ! empty($term->parent) ? 'h1' : 'h2';
        ?>
        <section class="taxonomy-header mt-[28px] md:mt-[48px]">
            <<?php echo tag_escape($heading_tag); ?> class="font-[Poppins] font-bold text-[#262626] tracking-[-0.02em] text-[clamp(1.11rem,2vw,1.60rem)] leading-[clamp(1.65rem,2.5vw,2.20rem)] mb-[20px] flex gap-[12px]"> <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.67188 4.94922H27.651V27.8733" stroke="#4A78FF" stroke-miterlimit="10"/><path d="M27.502 5.0957L4.82031 27.723" stroke="#4A78FF" stroke-miterlimit="10"/></svg> <span><?php echo esc_html($term->name); ?></span></<?php echo tag_escape($heading_tag); ?>>
                    <div class="taxonomy-description mt-4 font-[Poppins] font-normal text-[#525252] 
          text-[16px] leading-[1.75rem]">
                    <?php echo wp_kses_post(wpautop($term->description)); ?>
                </div>
        </section>
        <?php endif; ?>
</div>
