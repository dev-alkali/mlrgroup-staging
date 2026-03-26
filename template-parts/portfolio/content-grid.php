<?php
$taxonomy = 'portfolio-category';
$current_term = get_queried_object();
$term_id = isset($current_term->term_id) ? absint($current_term->term_id) : 0;
?>

<div class="flex flex-col items-start gap-5 flex-1 min-w-0 justify-center w-full md:w-auto">
    <div class="flex items-center justify-end w-full">
        <!-- <button type="button" id="view-inquery-list" class="btn-primary relative inline-flex items-center gap-2" aria-label="View inquiry list, 3 items">
            <div class="inline-flex items-center gap-2 justify-center">
                <div class="relative w-[17px] h-4 mt-[-2px]">
                    <img src=" //esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-white-large.svg'); ?>" alt="arrow">
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
        </button> -->
    </div>

    <div class="w-full">
        <div id="portfolio-grid" class="grid grid-cols-2 lg:grid-cols-3 w-full">
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
                    <article class="gallery-card group">
                        <div class="card-image-wrap relative overflow-hidden aspect-[333.33/360] w-full" style="background-image: url('<?= esc_url($image_url); ?>'); background-position: 50% 50%; background-size: cover; background-repeat: no-repeat;">
                            <div class="card-overlay absolute inset-0 [background:linear-gradient(312deg,rgba(0,0,0,0.82)_0%,rgba(253,67,56,0.82)_100%)] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-2 px-6 flex flex-col">
                                <button type="button" item-id="<?= esc_attr($post_id); ?>" class="view-inquery bg-black flex items-center justify-center gap-2 p-[13px] md:p-[16px] md:w-full rounded-[30px] cursor-pointer border-0 hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors translate-y-3 card-btn-transition md:max-w-[262px]">
                                    <span class="font-heading font-medium flex items-center justify-center  text-white text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap"><img class="h-[14px] w-[14px] mt-[-1px] md:mr-[8px]" src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/magnifying.svg'); ?>" alt=""> <span class="hidden md:inline-block">QUICK VIEW</span></span>
                                </button>
                                <button type="button" item-id="<?= esc_attr($post_id); ?>" class="add-inquiry bg-white flex items-center justify-center gap-2 p-[13px] md:p-[16px] md:w-full rounded-[30px] cursor-pointer border-0 hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#262626] transition-colors translate-y-3 card-btn-transition md:max-w-[262px]">
                                    <span class="font-heading font-semibold flex justify-center items-center text-neutral-800 text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap"><img class="h-[14.3px] w-[14.3px] mt-[-2px] md:mr-[8px]" src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/plus-black.svg'); ?>" alt=""> <span class="hidden md:inline-block">ADD TO INQUIRY LIST</span></span>
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


    <?php
        $term = get_queried_object(); // Current taxonomy term
        ?>
        <?php if ( !empty($term->description) ) : ?>
        <section class="taxonomy-header mt-[28px] md:mt-[48px]">
            <h1 class="font-[Poppins] font-bold text-[#262626] tracking-[-0.02em] text-[clamp(1.125rem,2vw,1.75rem)] leading-[clamp(1.75rem,2.5vw,2.25rem)] mb-[20px] flex gap-[12px]"><svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.67188 4.94922H27.651V27.8733" stroke="#4A78FF" stroke-miterlimit="10"/><path d="M27.502 5.0957L4.82031 27.723" stroke="#4A78FF" stroke-miterlimit="10"/></svg> <span><?php echo esc_html($term->name); ?></span></h1>
                    <div class="taxonomy-description mt-4 font-[Poppins] font-normal text-[#525252] 
          text-[clamp(1rem,2vw,1.25rem)] leading-[clamp(1.5rem,2.5vw,1.75rem)]">
                    <?php echo wp_kses_post($term->description); ?>
                </div>
        </section>
        <?php endif; ?>
</div>