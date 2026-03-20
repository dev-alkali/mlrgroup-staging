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

        <section id="<?php echo esc_attr($id); ?>" class="performance <?php echo esc_attr($className); ?> flex flex-col w-full items-center gap-[60px] pt-10 pb-[76px] md:pb-[180px] px-4 md:px-10 bg-black overflow-hidden">

            <div class="flex flex-col items-center gap-5 w-full max-w-[1920px] mb-[-76px] md:mb-[-180px]">

                <div class="flex max-w-[1920px] w-full flex-col xl:flex-row xl:items-center justify-between gap-8 sm:gap-[50px] lg:gap-[100px]">
                    <!-- Title -->
                    <div class="flex items-center md:justify-center gap-2 xl:max-w-[322px]">
                        <h2 class="text-[44px] md:text-5xl leading-[56px] font-bold tracking-[-2%] font-[poppins] text-white">
                            <?= wp_kses_post(get_sub_field('title')) ?>
                            <span class="text-[#4a78ff]">.</span>
                        </h2>
                    </div>    

                    <!-- Info Items -->
                    <div class="
    w-full max-w-[938px] flex-1
    grid grid-cols-2 gap-6
    md:flex md:flex-wrap md:justify-evenly lg:justify-between md:gap-4
    xl:flex-wrap
">

    <?php if (have_rows('infos')) : while (have_rows('infos')) : the_row(); ?>

        <div class="performance-item flex flex-col items-start md:items-center gap-1 md:gap-3 w-full md:max-w-[163px]">

            <div class="relative flex items-center md:justify-center text-[40px] md:text-[50px] lg:text-6xl leading-[48px] md:leading-[52px] font-bold tracking-[-2%] font-[poppins] text-white">                    
                
                <div class="invisible" aria-hidden="true">
                    <?= wp_kses_post(get_sub_field('value')) ?>
                </div>

                <div class="absolute count-box tabular-nums">
                    <?= wp_kses_post(get_sub_field('value')) ?>
                </div>

            </div>

            <p class="text-[14px] md:text-base leading-[20px] md:leading-6 text-white font-body md:text-center md:max-w-[133px]">
                <?= wp_kses_post(get_sub_field('description')) ?>
            </p>

        </div>

    <?php endwhile; endif; ?>

</div>
                </div>

                <div class="arrows-row flex max-w-[1360px] w-full items-center justify-center gap-3  overflow-hidden max-[1200px]:[&>img:nth-child(1)]:hidden max-[1024px]:[&>img:nth-child(2)]:hidden max-[768px]:[&>img:nth-child(3)]:hidden max-[640px]:[&>img:nth-child(4)]:hidden">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin-red.svg" class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">

                </div>
            </div>
        </section>
<?php endwhile;
endif; ?>