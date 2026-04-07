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
<?php if (have_rows('case_studies_grid')) :  while (have_rows('case_studies_grid')) : the_row(); ?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center pt-20 px-0 bg-black">    
        <div class="max-w-[1920px]">
        <!-- Heading -->
        <div class="w-full flex flex-col items-start justify-center gap-5 px-4 sm:px-10">            
            <h2 class="flex flex-col max-w-[660px] font-heading text-black tracking-[-0.02em] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)]">
                <span class="font-bold">
                    <?= wp_kses_post(get_sub_field('title_row_1')) ?>
                </span>
                <span class="font-light text-neutral-500">
                    <?= wp_kses_post(get_sub_field('title_row_2')) ?>
                </span>
            </h2>
        </div>

        <!-- Case Studies Grid -->
        <div class="w-full flex cs-cards <?php echo count(get_sub_field('works_rows')) ?>">
            <?php if (have_rows('works_rows')) : while (have_rows('works_rows')) : the_row(); ?>
                <?php if (have_rows('works')) : while (have_rows('works')) : the_row(); ?>
                    <a href="<?php echo esc_url(get_sub_field('item_path')); ?>"
                       class="cs-card w-full h-[240px] sm:h-[300px] md:h-auto md:aspect-[360/400]"
                       style="
                            background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
                            background-position: 50% 50%;
                            background-size: cover;
                            background-repeat: no-repeat;">
                            
                        <div class="gradient-box flex flex-col items-center justify-center gap-2 px-3 sm:px-6 py-4 sm:py-6 h-full">
                            
                            <?php if(get_sub_field('logo_image')): ?>
                                <div class="cs-card__logo">
                                    <img src="<?php echo get_sub_field('logo_image'); ?>" alt="">
                                </div>
                            <?php endif; ?>

                            <div class="cs-card__content flex items-center justify-end gap-1 sm:gap-2 w-full">
                                <div class="flex-1 text-white uppercase font-heading font-semibold text-[clamp(14px,1.64vw,24px)] leading-[clamp(18px,2.25vw,32px)] whitespace-nowrap">                                    
                                    <?= wp_kses_post(get_sub_field('title')) ?>
                                </div>
                                <img class="arrow relative w-[11px] sm:w-[20px] xl:w-[24px] h-[10px] sm:h-5 xl:h-6 mt-[-2px]" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="Arrow">
                            </div>
                        </div>
                        
                    </a>
                <?php endwhile; endif; ?>
            <?php endwhile; endif; ?>
        </div>

        <?php
            $view_more = get_sub_field('view_more');
            if($view_more):
        ?>
           <a class="flex items-center" href="<?php echo $view_more['url']; ?>" target="<?php echo $view_more['target']; ?>">
            <span><?php echo $view_more['title']; ?></span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="#FD4338" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.26562 2.47656H13.407V13.9386" stroke-miterlimit="10"/><path d="M13.3351 2.54688L2.33789 13.8605" stroke-miterlimit="10"/> </svg></a>
        <?php endif; ?>

    </div>
</section>


<?php endwhile;
endif; ?>