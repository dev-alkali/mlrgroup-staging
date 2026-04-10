<?php

/**
 * Our Work Grid Block Template.
 */

$id = 'our-work-grid-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'our-work-grid';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('our_work_grid')) :  while (have_rows('our_work_grid')) : the_row();

    $section_remove_top_padding    = get_sub_field('section_remove_top_padding');
    $section_remove_bottom_padding = get_sub_field('section_remove_bottom_padding');

    $pt_class = '';
    if ( ! empty( $section_remove_top_padding ) ) {
        $pt_class = ' ' . 'pt0';
    }

    $pb_class = '';
    if ( ! empty( $section_remove_bottom_padding ) ) {
        $pb_class = ' ' . 'pb0';
    }
?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center pt-20 px-0 bg-white<?php echo $pt_class; ?><?php echo $pb_class; ?>">    
        <div class="flex flex-col w-full items-center gap-10">
        <!-- Heading -->
        <div class="px-4 sm:px-10">
            <div class="wrapper w-full flex flex-col items-start justify-center gap-5 ">            
                <h2 class="flex flex-col max-w-[560px] font-heading text-black tracking-[-0.02em] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,80px)]">
                    <span class="font-bold">
                        <?= wp_kses_post(get_sub_field('title_row_1')) ?>
                    </span>
                    <span class="font-bold">
                        <?= wp_kses_post(get_sub_field('title_row_2')) ?> 
                    </span>
                </h2>
            </div>
        </div>

        <!-- Work Grid -->
        <div class="w-full bg-white grid grid-cols-2 lg:grid-cols-4">
            <?php if (have_rows('works_rows')) : while (have_rows('works_rows')) : the_row(); ?>
                <?php if (have_rows('works')) : while (have_rows('works')) : the_row(); ?>
                    <a href="<?php echo esc_url(get_sub_field('item_path')); ?>"
                       class="work-card w-full h-[240px] sm:h-[300px] md:h-auto md:aspect-[360/400]"
                       style="
                            background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
                            background-position: 50% 50%;
                            background-size: cover;
                            background-repeat: no-repeat;">
                        <div class="gradient-box flex flex-col items-start justify-end gap-2 px-3 sm:px-6 py-4 sm:py-7 h-full">
                            <div class="content flex items-center justify-end gap-1 sm:gap-2 w-full">
                                <div class="flex-1 text-white uppercase font-heading font-semibold text-[clamp(12px,1.4vw,18px)] leading-[clamp(18px,2vw,28px)] whitespace-nowrap">                                    
                                    <?= wp_kses_post(get_sub_field('title')) ?>
                                </div>
                                <img class="arrow relative w-[11px] sm:w-[20px] xl:w-[24px] h-[10px] sm:h-5 xl:h-6 mt-[-2px]" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="Arrow">
                            </div>
                        </div>
                    </a>
                <?php endwhile; endif; ?>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>


<?php endwhile;
endif; ?>