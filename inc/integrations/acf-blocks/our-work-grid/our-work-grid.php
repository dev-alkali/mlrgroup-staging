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
<?php if (have_rows('our_work_grid')) :  while (have_rows('our_work_grid')) : the_row(); ?>

        <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center  pt-20 px-0 bg-white">
            <div class="flex flex-col w-full items-center gap-10">
                <div class="max-w-[1920px] flex flex-col items-start justify-center gap-5 px-4 min-[642px]:px-10 w-full">
                    <h2 class="flex flex-col max-w-[512px] text-black text-[44px] min-[600px]:ext-[50px] min-[800px]:text-[68px]  tracking-[-2%] leading-[56px]  min-[600px]:leading-[70px] min-[800px]:leading-[80px] font-heading">
                        <span class="font-bold"><?= wp_kses_post(get_sub_field('title_row_1')) ?> </span>
                        <span class="font-light text-neutral-500"><?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
                    </h2>
                </div>

                <div class="flex flex-row lg:flex-col items-start w-full bg-white">

                    <?php if (have_rows('works_rows')) :  while (have_rows('works_rows')) : the_row(); ?>
                            <div class="flex flex-col lg:flex-row  max-[1024px]:justify-center w-1/2 lg:w-full">
                                <?php if (have_rows('works')) :  while (have_rows('works')) : the_row(); ?>

                                        <a href="<?php echo esc_url(get_sub_field('item_path')); ?>" class="work-card w-full  h-[240px] min-[600px]:h-[300px] min-[642px]:h-auto min-[642px]:aspect-[360/400]"
                                            style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 50%;
    background-size: cover;
    background-repeat: no-repeat; ">
                                            <div class="  gradient-box flex flex-col items-start justify-end gap-2 px-3 min-[600px]:px-6 py-4 min-[600px]:py-7 h-full">

                                             
                                                <div class="content flex items-center justify-end gap-1 min-[600px]:gap-2 w-full">

                                                    <div class="flex-1 text-white uppercase text-[12px] max-[600px]:whitespace-nowrap min-[600px]:text-[16px] min-[642px]:text-lg leading-[18px] min-[600px]:leading-[20px] min-[642px]:leading-7 font-heading font-semibold min-[600px]:font-bold">
                                                        <?= wp_kses_post(get_sub_field('title')) ?>
                                                    </div>

                                                    <img
                                                        class="arrow relative w-[11px] min-[600px]:w-[20px] min-[642px]:w-[24.7px] h-[10px] min-[600px]:h-5 min-[642px]:h-6 mt-[-2px]"
                                                        src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg"
                                                        alt="">

                                                </div>
                                            </div>
                                        </a>
                                <?php endwhile;
                                endif; ?>
                            </div>

                    <?php endwhile;
                    endif; ?>


                </div>
            </div>

        </section>
<?php endwhile;
endif; ?>