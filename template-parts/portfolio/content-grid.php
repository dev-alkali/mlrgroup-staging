<?php
$taxonomy = 'portfolio-category';
$current_term = get_queried_object();
$term_id = isset($current_term->term_id) ? absint($current_term->term_id) : 0;
?>

<div class="flex flex-col items-start gap-5 flex-1 min-w-0 max-[1960px]:mr-10 justify-center">
    <div class="flex items-center justify-end w-full">
        <button type="button" id="view-inquery-list" class="btn-primary relative inline-flex items-center gap-2" aria-label="View inquiry list, 3 items">
            <div class="inline-flex items-center gap-2 justify-center">
                <div class="relative w-[17px] h-4 mt-[-2px]">
                    <img src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-white-large.svg'); ?>" alt="arrow">
                </div>
                <span class="font-heading font-semibold text-white text-sm md:text-base tracking-[0] leading-7 whitespace-nowrap">
                    VIEW INQUIRY LIST
                </span>
            </div>
            <span aria-label="3 items in list" class="inline-flex items-center justify-center w-[26px] h-[26px] absolute -top-1 -right-1 bg-black rounded-full">
                <span class="inquiry-list-quantity font-heading font-normal text-white text-[16px] text-center leading-none mb-[-1px]" aria-hidden="true">
                    0
                </span>
            </span>
        </button>
    </div>

    <div class="flex flex-col items-center justify-center gap-10 md:gap-[60px] w-full">
        <div id="portfolio-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 w-fit min-[1440px]:w-full justify-end">
            <?php
            $query_args = array(
                'post_type'      => 'portfolio',
                'posts_per_page' => 12,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            );

            if ($term_id > 0) {
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                );
            }

            $portfolio_query = new WP_Query($query_args);

            if ($portfolio_query->have_posts()) :
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    $post_id = get_the_ID();
                    $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'full') : '';
            ?>
                    <article class="gallery-card group flex w-fit min-[1440px]:w-full flex-col items-start gap-3">
                        <div class="card-image-wrap relative overflow-hidden max-[1441px]:h-[360px] max-[1441px]:max-w-[333.3px] aspect-[333.33/360] w-full" style="background-image: url('<?= esc_url($image_url); ?>'); background-position: 50% 50%; background-size: cover; background-repeat: no-repeat;">
                            <div class="card-overlay absolute inset-0 [background:linear-gradient(312deg,rgba(0,0,0,0.82)_0%,rgba(253,67,56,0.82)_100%)] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-2 px-6">
                                <button type="button" item-id="<?= esc_attr($post_id); ?>" class="view-inquery bg-black flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors translate-y-3 card-btn-transition">
                                    <span class="font-heading font-medium flex items-center justify-center  text-white text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap"><img class="h-[14px] w-[14px] mt-[-1px] mr-[8px]" src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/magnifying.svg'); ?>" alt="">QUICK VIEW</span>
                                </button>
                                <button type="button" item-id="<?= esc_attr($post_id); ?>" class="add-inquiry bg-white flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#262626] transition-colors translate-y-3 card-btn-transition">
                                    <span class="font-heading font-semibold flex justify-center items-center text-neutral-800 text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap"><img class="h-[14.3px] w-[14.3px] mt-[-2px] mr-[8px]" src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/plus-black.svg'); ?>" alt="">ADD TO INQUIRY LIST</span>
                                </button>
                            </div>
                        </div>
                    </article>
            <?php
                endwhile;
            endif;
            ?>
        </div>

        <?php if ($portfolio_query->max_num_pages > 1) : ?>
            <a href="#" id="load-more-portfolio" data-term="<?= esc_attr($term_id); ?>"

                data-paged="2"
                data-max-pages="<?= esc_attr($portfolio_query->max_num_pages); ?>" class="inline-flex items-center gap-2 no-underline hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd4338] transition-opacity rounded">
                <span class="font-heading font-semibold text-[#fd4338] text-base tracking-[0] leading-6 whitespace-nowrap">
                    SEE ALL
                </span>
                <img class="w-4 h-4 mt-[-3px]" src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-red.svg'); ?>" alt="" />
            </a>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
</div>