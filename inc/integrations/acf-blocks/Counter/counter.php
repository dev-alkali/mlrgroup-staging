<?php

/**
 * Counter Block Template.
 */

$id = 'counter-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'counter';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('counter')) :  while (have_rows('counter')) : the_row(); ?>

        <section id="<?php echo esc_attr($id); ?>" class="performance <?php echo esc_attr($className); ?> flex flex-col w-full items-center  gap-[60px] pt-10 pb-[76px] min-[600px]:pb-[180px] px-4 min-[600px]:px-10 bg-black overflow-hidden">

            <div class="flex flex-col items-center gap-5 w-full max-w-[1920px] mb-[-76px] min-[600px]:mb-[-180px]">
                <div class="flex max-w-[1920px] justify-between flex-col min-[800px]:flex-row w-full min-[800px]:items-center gap-8 min-[600px]:gap-[50px] min-[890px]:gap-[100px] bg-black">
                    <div class="flex max-[1441px]:max-w-[322px] items-center min-[567px]:justify-center gap-2">
                        <h2 class="text-[44px] min-[600px]:text-5xl leading-[56px] font-bold  tracking-[-2%] font-[poppins] text-white">
                            <?= wp_kses_post(get_sub_field('title')) ?>
                            <span class="text-[#4a78ff]">.</span>
                        </h2>
                    </div>
    
                    <div class="flex items-center max-w-[938px] w-full justify-between min-[567px]:justify-evenly min-[1023px]:justify-between gap-8 min-[600px]:gap-4 max-[1440px]:flex-wrap flex-1">


                        <?php if (have_rows('infos')) :  while (have_rows('infos')) : the_row(); ?>
                                <div class="performance-item inline-flex flex-col max-[567px]:max-w-[163px] max-[567px]:w-full  w-max min-[567px]:items-center gap-1 min-[600px]:gap-3">

                                    <div class="relative flex items-center justify-items-start min-[567px]:justify-center text-[40px] min-[600px]:text-[50px] min-[890px]:text-6xl leading-[48px] min-[600px]:leading-[52px] font-bold tracking-[-2%] font-[poppins] text-white">

                                        <div class="invisible" aria-hidden="true">
                                            <?= wp_kses_post(get_sub_field('value')) ?>
                                        </div>

                                        <div class="absolute count-box tabular-nums">
                                            <?= wp_kses_post(get_sub_field('value')) ?>
                                        </div>

                                    </div>

                                    <p class="min-[567px]:max-w-[133px] text-[14px] min-[600px]:text-base leading-[20px] min-[600px]:leading-6 text-white font-body min-[567px]:text-center">
                                        <?= wp_kses_post(get_sub_field('description')) ?>
                                    </p>

                                </div>
                        <?php endwhile;
                        endif; ?>

                    </div>
                </div>

                <div class="arrows-row 
flex max-w-[1360px] w-full 
items-center justify-center gap-3  overflow-hidden

max-[1200px]:[&>img:nth-child(1)]:hidden
max-[1024px]:[&>img:nth-child(2)]:hidden
max-[768px]:[&>img:nth-child(3)]:hidden
max-[640px]:[&>img:nth-child(4)]:hidden
">

                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">

                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">

                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">

                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">


                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">
                    <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-thin-red.svg"
                        class="arrow w-[clamp(49px,8vw,120px)] h-[clamp(47px,8vw,117px)]" alt="">

                </div>
            </div>
        </section>
<?php endwhile;
endif; ?>