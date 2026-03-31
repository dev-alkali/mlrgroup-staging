<?php

/**
 * Collection Block Template.
 */

$id = 'collection-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'collection';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('collection')) :  while (have_rows('collection')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-[120px] bg-white flex justify-center flex-wrap">
        <div class="flex flex-col w-full items-start gap-8 min-[600px]:gap-[60px] max-w-[1920px]">
                <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>

                    <div class="flex flex-col  items-start gap-5 relative ">
                    <h2
                        class=" flex flex-col font-heading text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)] tracking-[-2%] max-w-[700px]">
                        <span class="font-bold text-neutral-800 "><?= wp_kses_post(get_sub_field('title_row_1')) ?> </span>
                        <span class="font-light text-neutral-500 "><?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
                    </h2>


                    <p
                        class=" font-body  text-neutral-600 text-[clamp(18px,2vw,20px)] leading-[clamp(26px,2.6vw,28px)] tracking-[0] leading-7">
                        <?= wp_kses_post(get_sub_field('paragraph')) ?>
                    </p>

                    </div>
                <?php endwhile;
                endif; ?>

                <?php if (have_rows('main_content')) :  while (have_rows('main_content')) : the_row(); ?>
                    <div class="flex-col items-start max-[600px]:gap-6 max-[1024px]:gap-10 w-full flex-[0_0_auto] flex relative">
                    <?php if (have_rows('collection_rows')) :  while (have_rows('collection_rows')) : the_row(); ?>
                        <?php
                        // $row_height = "";
                        // if (wp_kses_post(get_sub_field('row_height')) == 'normal') {
                        //   $row_height = ' min-[1024px]:h-[409px] ';
                        // } elseif (wp_kses_post(get_sub_field('row_height')) == 'big') {
                        //   $row_height = ' min-[1024px]:h-[434.56px] min-[1440px]:aspect-[334/434]';
                        // }
                        ?>
                        <?php
                        $row_height = "";
                        if (wp_kses_post(get_sub_field('row_height')) == 'normal') {
                            // 1440 (largura total) / 409 (altura desejada)
                            $row_height = ' min-[1441px]:aspect-[1440/409] max-[1441px]:h-[409px] max-[1024px]:h-auto ';
                        } elseif (wp_kses_post(get_sub_field('row_height')) == 'big') {
                            // 1440 (largura total) / 434 (altura desejada)
                            $row_height = ' min-[1441px]:aspect-[1440/434] max-[1441px]:h-[434.56px] max-[1024px]:h-auto ';
                        }
                        ?>
                        <div class="flex flex-col min-[1024px]:flex-row max-[600px]:gap-6 max-[1024px]:gap-10 items-start relative <?= $row_height ?> w-full collection-parent">
                            <?php if (have_rows('items')) :  while (have_rows('items')) : the_row(); ?>

                                <?php
                                $bg_color = '';
                                $bg_image = esc_url(get_sub_field('bg_image'));
                                if (wp_kses_post(get_sub_field('bg_color')) == 'white') {
                                $bg_color = "bg-white";
                                } elseif (wp_kses_post(get_sub_field('bg_color')) == 'gray') {
                                $bg_color = "bg-[#CCCCCC]";
                                } elseif (wp_kses_post(get_sub_field('bg_color')) == 'blue') {

                                $bg_color = "bg-[#4a78ff]";
                                }
                                $text_color = "";
                                $arrow_color = "";
                                if (wp_kses_post(get_sub_field('text_color')) == 'white') {
                                $text_color = "text-white";
                                $arrow_color = get_template_directory_uri() . "/assets/imgs/Arrow.svg";
                                } elseif (wp_kses_post(get_sub_field('text_color')) == 'black') {
                                $text_color = "text-black";
                                $arrow_color = get_template_directory_uri() . "/assets/imgs/Arrow-black.svg";
                                }

                                ?>
                                <div class="<?= $text_color ?> collection-item h-[380px] min-[600px]:h-[420px] max-[1024px]:w-full min-[1024px]:h-full  min-[1024px]:flex-1 min-[1024px]:grow <?= $bg_image == "" ? $bg_color : "" ?>" <?= $bg_image !== "" ? 'style="
                                        background-image: url(' . $bg_image . ');
                                        background-position: 50% 50%;
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                    "' : ""; ?>>
                                <a href="<?= wp_kses_post(get_sub_field('link_path')) ?>" class=" <?= $bg_image == "" ? "color-bg-hover" : "collection-gradient-box" ?> flex flex-col  items-end justify-between w-full h-full px-6 py-10 relative">
                                    <div class="flex flex-col relative z-20 items-start <?= esc_url(get_sub_field('icon')) !== "" ? "" : "pt-[88px]"; ?> gap-5 relative self-stretch w-full flex-[0_0_auto]">
                                    <?php if (esc_url(get_sub_field('icon')) !== ""): ?>
                                        <img
                                        Crop
                                        class="relative w-[70px] h-[70px] object-cover"
                                        src=" <?= esc_url(get_sub_field('icon')) ?>"
                                        alt="icon" />
                                    <?php endif; ?>

                                    <p
                                        class="relative  font-heading text-[20px] min-[600px]:text-[24px] max-w-[406px] tracking-[-2%] leading-7 min-[600px]:leading-8">
                                        <?= wp_kses_post(get_sub_field('title')) ?>
                                    </p>
                                    </div>

                                    <p class="inline-flex  z-20  gap-2 relative flex-[0_0_auto]">
                                    <span
                                        class="relative w-fit  uppercase font-heading font-semibold text-base text-center tracking-[0] leading-6 min-[600px]:leading-[18px] whitespace-nowrap">
                                        <?= wp_kses_post(get_sub_field('link_label')) ?>
                                    </span>
                                    <img class="relative w-4 h-4 max-[600px]:mt-[3px] arrow" src="<?= $arrow_color ?>" alt="arrow" />

                                    </p>
                                </a>

                                </div>
                            <?php endwhile;
                            endif; ?>




                        </div>
                    <?php endwhile;
                    endif; ?>

                    </div>

                <?php endwhile;
                endif; ?>
        </div>
        <?php 
                $btn = get_sub_field('btn');
                if( $btn ): 
                    $btn_url = $btn['url'];
                    $btn_title = $btn['title'];
                    $btn_target = $btn['target'] ? $btn['target'] : '_self';
                    ?>
                    <div class="text-center flex items-center justify-center gap-2 mt-[40px] w-full">
                        <a class="relative w-fit uppercase font-heading font-semibold text-accent text-center tracking-[0] leading-[24px] min-[600px]:leading-[18px] whitespace-nowrap view-more-btn flex items-center justify-center gap-2" href="<?php echo esc_url( $btn_url ); ?>" target="<?php echo esc_attr( $btn_target ); ?>">
                            <?php echo esc_html( $btn_title ); ?>
                            <img class="relative md:w-4 md:h-4 w-[11px] h-[11px] arrow" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" alt="Arrow">
                        </a>
                    </div>
                <?php endif; ?>
    </section>
<?php endwhile;
endif; ?>