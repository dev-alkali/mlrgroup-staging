<?php

/**
 * Case Studies Grid Block Template.
 */

$id = 'case-studies-grid-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'case-studies-grid';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
 
 <?php if (have_rows('case_studies_grid')) : while (have_rows('case_studies_grid')) : the_row(); ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> py-20 md:py-30 px-6 md:px-10 bg-black">    

    <div class="flex flex-col gap-8 xl:gap-12"> 

        <!-- Heading -->
        <div class="w-full">            
            <h2 class="flex flex-col max-w-[660px] font-heading text-white tracking-tight text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)]">
                <span class="font-bold">
                    <?= wp_kses_post(get_sub_field('title_row_1')) ?>
                </span>
                <span class="font-light">
                    <?= wp_kses_post(get_sub_field('title_row_2')) ?>
                </span>
            </h2>
        </div>

        <!-- Grid -->
        <div class="flex flex-col gap-10 md:gap-8 cs-cards">

            <?php 
            $posts = get_sub_field('case_studies'); 

            if ($posts) :
                foreach ($posts as $post) :
                    setup_postdata($post);

                    $image_url = get_the_post_thumbnail_url($post->ID, 'full');
                    $cs_logo = get_field('cs_logo', $post->ID);
                    $custom_card_title = get_field('custom_card_title', $post->ID);
            ?>

            <a href="<?php the_permalink($post->ID); ?>"
               class="relative flex items-end px-6 bg-cover bg-center cs-card"
               style="background-image:url('<?php echo esc_url($image_url); ?>')">


                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    
                  <img class="arrow absolute z-9 w-[24px] md:w-[32px] xl:w-[40px] h-[24px] md:h-[32px] xl:h-[40px]" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="Arrow">
                
                <?php if ($cs_logo): ?>
                    <div class="cs-card__logo absolute default-logo z-9">
                        <img src="<?php echo esc_url($cs_logo['url']); ?>" 
                                alt="<?php echo esc_attr($cs_logo['alt']); ?>" 
                                class="max-h-10">
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="relative z-10 w-full py-8">
                   
                    <?php if ($cs_logo): ?>
                        <div class="cs-card__logo mb-4 md:mb-5 hover-logo">
                            <img src="<?php echo esc_url($cs_logo['url']); ?>" 
                                 alt="<?php echo esc_attr($cs_logo['alt']); ?>" 
                                 class="max-h-10">
                        </div>
                    <?php endif; ?>
                    <h3 class="cs-card__text text-white uppercase font-heading font-semibold text-[clamp(16px,1.64vw,24px)] leading-[clamp(22px,2.25vw,32px)] text-white uppercase font-heading font-semibold text-lg md:text-xl">
                        <?php echo $custom_card_title ?: get_the_title($post->ID); ?>
                    </h3>
                </div>
            </a>

            <?php endforeach; wp_reset_postdata(); endif; ?>

        </div>

        <!-- View More -->
        <?php 
        $view_more_link = get_sub_field('view_more_link');
        if ($view_more_link): ?>
            <a class="inline-flex items-center gap-2 text-white font-semibold"
               href="<?php echo esc_url($view_more_link['url']); ?>"
               target="<?php echo esc_attr($view_more_link['target']); ?>">
                <span><?php echo esc_html($view_more_link['title']); ?></span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.26562 2.47656H13.407V13.9386" stroke="#FD4338" stroke-miterlimit="10"/>
                <path d="M13.3351 2.54688L2.33789 13.8605" stroke="#FD4338" stroke-miterlimit="10"/>
                </svg>
            </a>
        <?php endif; ?>

    </div>

</section>

<?php endwhile; endif; ?>