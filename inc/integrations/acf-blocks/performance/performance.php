<?php

/**
 * Performance Block Template.
 */

$id = 'performance-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'performance';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('performance')) :  while (have_rows('performance')) : the_row(); ?>

        <section id="<?php echo esc_attr($id); ?>" class="performance <?php echo esc_attr($className); ?> flex flex-col w-full items-center gap-[60px] pt-10 md:pb-[120px] pb-[100px] md:pb-[180px] px-4 md:px-10 bg-black overflow-hidden">

            <div class="flex flex-col items-center gap-5 w-full max-w-[1920px] mb-[-76px] md:mb-[-180px]">

                <div class="flex max-w-[1920px] w-full flex-col xl:flex-row xl:items-center justify-between gap-8 sm:gap-[50px] lg:gap-[100px]">
                    <!-- Title -->
                    <div class="flex items-center gap-2 xl:max-w-[322px]">
                        <h2 class="font-bold font-[poppins] text-white tracking-[-0.02em] text-[clamp(36px,3.5vw,48px)] leading-[clamp(44px,4vw,56px)]">
                            <?= wp_kses_post(get_sub_field('title')) ?><span class="text-[#4a78ff]">.</span>
                        </h2>
                    </div>    

                    <!-- Info Items -->
                    <div class="w-full max-w-[938px] flex-1 grid grid-cols-2 gap-6 md:flex md:flex-wrap md:justify-evenly lg:justify-between md:gap-2 lg:gap-4 xl:flex-wrap">
                        <?php if (have_rows('infos')) : while (have_rows('infos')) : the_row(); ?>
                            <div class="performance-item flex flex-col items-start md:items-center gap-1 md:gap-3 w-full md:max-w-[163px]">
                                <div class="relative flex items-center md:justify-center font-bold font-[poppins] text-white tracking-[-0.02em] text-[clamp(40px,4vw,60px)] leading-[clamp(48px,4.5vw,60px)]">
                                    <div class="invisible" aria-hidden="true">
                                        <?= wp_kses_post(get_sub_field('value')) ?>
                                    </div>

                                    <div class="absolute count-box tabular-nums">
                                        <?= wp_kses_post(get_sub_field('value')) ?>
                                    </div>
                                </div>
                                <p class="text-[clamp(14px,1.2vw,16px)] leading-[clamp(20px,1.6vw,24px)] text-white font-normal font-body md:text-center md:max-w-[133px]"> <?= wp_kses_post(get_sub_field('description')) ?></p>
                            </div>
                        <?php endwhile; endif; ?>
                    </div>
                </div>

                <div class="arrows-row flex max-w-[100%] w-full items-center justify-center min-[1500px]:gap-[4%] xl:gap-[30px] gap-3 overflow-hidden max-[1200px]:[&>img:nth-child(1)]:hidden max-[1024px]:[&>img:nth-child(2)]:hidden max-[768px]:[&>img:nth-child(3)]:hidden max-[640px]:[&>img:nth-child(4)]:hidden max-[640px]:[&>img:nth-child(5)]:hidden">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-white-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red-icon.svg" class="arrow1 w-[clamp(48px,7vw,120px)] h-[clamp(48px,7vw,117px)]" alt="">
                </div>
            </div>
        </section>
<?php endwhile;
endif; ?>