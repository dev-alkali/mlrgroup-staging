<?php

/**
 * Services Solutions Block Template.
 */

$id = 'services-solutions';

$className = 'services-solutions';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('services_solutions')) :  while (have_rows('services_solutions')) : the_row(); ?>
        <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> solutions-tabs-slider px-4  md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] flex justify-center">
            <div class="w-full flex items-center flex-col max-w-[1920px]">

                <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>
                        <!-- TITLE -->
                        <div class="solutions-header flex flex-col md:flex-row w-full max-w-[1920px] mb-8 md:mb-[60px] gap-3">
                            <?php 
                                $title_bold = get_sub_field('title_bold');
                                $title_light = get_sub_field('title_light');
                                $description = get_sub_field('description');
                            ?>

                            <?php if (!empty($title_bold) || !empty($title_light)) : ?>
                            <h2 class="solutions-header__title text-[44px] md:text-5xl leading-[56px] md:leading-[60px] tracking-[-2%] font-heading text-neutral-800 md:min-w-[360px] lg:min-w-[515px]">
                                <span class="font-bold text-neutral-800"><?= wp_kses_post(get_sub_field('title_bold')) ?></span>
                                <span class="font-light text-neutral-500"><?= wp_kses_post(get_sub_field('title_light')) ?><span class="text-accent font-bold">.</span></span>
                            </h2>                                
                            <?php endif; ?>

                            <?php if (!empty($description)) : ?>
                            <p class="solutions-header__description">
                                <?php echo wp_kses_post($description); ?>
                            </p>
                            <?php endif; ?>

                        </div>
                <?php endwhile;
                endif; ?>


                <!-- TABS -->
                <?php if (have_rows('main_content')) :  while (have_rows('main_content')) : the_row(); ?>
                        <div class="solutions-tabs mb-[40px] w-full max-w-[1920px] flex flex-nowrap overflow-x-auto min-[1141px]:overflow-x-visible">
                            <?php if (have_rows('service_group')) : while (have_rows('service_group')) : the_row(); ?>
                                    <div class="solutions-tab <?= get_row_index() === 1 ? 'is-active' : '' ?> max-[767px]:max-w-[184px] w-full md:min-w-[280px] lg:min-w-auto flex-none md:flex-1"
                                        data-solution="<?= wp_kses_post(get_sub_field('service_name')) ?>">
                                        <button class="px-[10.5px] md:px-2 min-[1206px]:px-6 w-full pt-[21px] md:pt-[27px] pb-[19px] md:pb-[25px] gap-2 capitalize md:uppercase font-medium">
                                            <img class="w-3 md:mt-[3px] md:w-[19px] h-3 md:h-[18px] arrow " src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-tabs.svg" alt="">
                                            <?= wp_kses_post(get_sub_field('service_name')) ?>
                                        </button>
                                    </div>
                            <?php endwhile;
                            endif; ?>
                        </div>

                        <!-- SLIDERS WRAPPER -->
                        <div class="solutions-sliders w-full ">
                            <?php if (have_rows('service_group')) :  while (have_rows('service_group')) : the_row(); ?>
                                    <!-- EXECUTION -->
                                    <div class="solutions-slider max-lg:hidden <?= get_row_index() === 1 ? 'is-active' : '' ?>" data-solution="<?= wp_kses_post(get_sub_field('service_name')) ?>">
                                        <div class="solutions-track">
                                            <?php if (have_rows('slider_solutions')) :  while (have_rows('slider_solutions')) : the_row(); ?>
                                                    <a class="solution-card max-lg:max-w-[400px]" href="<?= esc_url(get_sub_field('link_path')) ?>">
                                                        <div class="flex flex-col w-full items-start gap-4 relative">

                                                            <img class="self-stretch w-full h-[409px] object-cover" src="<?= esc_url(get_sub_field('image')) ?>" alt="">
                                                            <div class="flex flex-col w-[371px] items-start gap-4 relative flex-[0_0_auto] max-w-[100%]">
                                                                <div class="flex flex-col items-start gap-2 relative self-stretch w-full flex-[0_0_auto]">
                                                                    <div class="relative self-stretch font-heading font-bold text-[#262626] text-[24px] leading-[32px] tracking-[-0.02em]">
                                                                        <?= wp_kses_post(get_sub_field('title')) ?>
                                                                    </div>
                                                                    <p class="relative self-stretch font-body font-normal text-[#525252] text-[clamp(16px,1.2vw,18px)] leading-[28px]">
                                                                        <?= wp_kses_post(get_sub_field('paragraph')) ?>
                                                                    </p>
                                                                </div>
                                                                <p class="service-card-link inline-flex  gap-2 relative flex-[0_0_auto]">
                                                                    <span class="font-semibold text-accent uppercase relative w-fit whitespace-nowrap font-heading tracking-[0] text-[clamp(16px,1.5vw,18px)] leading-[clamp(24px,2vw,28px)]">
                                                                        <?= wp_kses_post(get_sub_field('link_label')) ?>
                                                                    </span>

                                                                    <img class="arrow relative w-4 h-4 mt-1" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" />
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                            <?php endwhile;
                                            endif; ?>
                                        </div>

                                        <button class="solutions-prev">
                                            <img class="rotate-180" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-slider.svg" alt="arrow">
                                        </button>
                                        <button class="solutions-next">
                                            <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-slider.svg" alt="arrow">
                                        </button>
                                        <div class="solutions-dots"></div>
                                    </div>
                                    <div class="solutions-columns <?= get_row_index() === 1 ? 'is-active' : '' ?> min-[1024px]:hidden"
                                        data-solution="<?= esc_attr(get_sub_field('service_name')) ?>">

                                        <div class="flex flex-row flex-wrap gap-8 justify-center">

                                            <?php if (have_rows('slider_solutions')) :  while (have_rows('slider_solutions')) : the_row(); ?>

                                                    <a href="<?= esc_url(get_sub_field('link_path')) ?>" class="solution-card  max-w-[400px]">
                                                        <div class="flex flex-col w-full items-start gap-4 relative">

                                                            <img class="self-stretch w-full h-[409px] object-cover" src="<?= esc_url(get_sub_field('image')) ?>" alt="">
                                                            <div class="flex flex-col w-full max-w-[358px] md:max-w-[371px] items-start gap-4 relative flex-[0_0_auto]">
                                                                <div class="flex flex-col items-start gap-2 relative self-stretch w-full flex-[0_0_auto]">
                                                                    <div class="relative self-stretch font-heading font-bold text-[#262626] text-[24px] leading-[32px] tracking-[-0.02em]">
                                                                        <?= wp_kses_post(get_sub_field('title')) ?>
                                                                    </div>
                                                                    <p class="relative self-stretch font-body font-normal text-[#525252] text-[clamp(16px,1.2vw,18px)] leading-[28px]">
                                                                        <?= wp_kses_post(get_sub_field('paragraph')) ?>
                                                                    </p>
                                                                </div>
                                                                <p class="service-card-link inline-flex  gap-2 relative flex-[0_0_auto]">
                                                                    <span class="font-semibold text-accent uppercase relative w-fit whitespace-nowrap font-heading tracking-[0] text-[clamp(16px,1.5vw,18px)] leading-[clamp(24px,2vw,28px)]">
                                                                        <?= wp_kses_post(get_sub_field('link_label')) ?>
                                                                    </span>

                                                                    <img class="arrow relative w-4 h-4 mt-[3px] md:mt-1" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" />
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>

                                            <?php endwhile;
                                            endif; ?>
                                        </div>
                                    </div>
                            <?php endwhile;
                            endif; ?>
                        </div>
                <?php endwhile;
                endif; ?>


                
            </div>
        </section>
<?php endwhile;
endif; ?>