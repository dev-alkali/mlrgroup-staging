<?php

/**
 * Case Studies Block Template.
 */

$id = 'case_studies-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'case_studies';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('case_studies')) :  while (have_rows('case_studies')) : the_row();

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

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> case-studies-sec flex justify-center px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] bg-white<?php echo $pt_class; ?><?php echo $pb_class; ?>">
      <div class="flex flex-col w-full items-start gap-8 md:gap-[60px] max-w-[1920px]">
        <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>

            <div class="flex flex-col  items-start gap-5 relative ">
              <h2
                class=" flex flex-col font-heading text-[44px] md:text-[54px] min-[767px]:text-[68px] tracking-[-2%] max-w-[700px] leading-[56px] md:leading-[64px] min-[767px]:leading-[78px]">
                <span class="font-bold text-neutral-800 "><?= wp_kses_post(get_sub_field('title_row_1')) ?> </span>
                <span class="font-bold text-neutral-800 "><?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
              </h2>
              <p
                class=" font-body  text-neutral-600 text-[clamp(18px,2vw,20px)] leading-[clamp(26px,2.6vw,28px)] tracking-[0]">
                <?= wp_kses_post(get_sub_field('paragraph')) ?>
              </p>

            </div>
        <?php endwhile;
        endif; ?>

       <?php if (have_rows('main_content')) : while (have_rows('main_content')) : the_row();

    $items_raw  = get_sub_field('items') ?: [];
    $item_count = count($items_raw);
    $item_index = 0;

    // ── For 5-col: pre-collect all item data before rendering ──────────────
    // This avoids row-pointer conflicts and lets us build a nested flex structure.
    $five_items = [];
    if ($item_count === 5 && have_rows('items')) {
        while (have_rows('items')) {
            the_row();
            $five_items[] = [
                'bg_image'   => esc_url(get_sub_field('bg_image')),
                'bg_color'   => wp_kses_post(get_sub_field('bg_color')),
                'text_color' => wp_kses_post(get_sub_field('text_color')),
                'icon'       => esc_url(get_sub_field('icon')),
                'title'      => wp_kses_post(get_sub_field('title')),
                'link_path'  => wp_kses_post(get_sub_field('link_path')),
                'link_label' => wp_kses_post(get_sub_field('link_label')),
            ];
        }
    }

    // ── Helper: resolve bg/text/arrow from collected item data ──────────────
    $resolve = function(array $item) {
        $bg_color = '';
        if ($item['bg_color'] === 'white')     $bg_color = 'bg-white';
        elseif ($item['bg_color'] === 'gray')  $bg_color = 'bg-[#CCCCCC]';
        elseif ($item['bg_color'] === 'blue')  $bg_color = 'bg-[#4a78ff]';

        $text_color  = '';
        $arrow_color = '';
        if ($item['text_color'] === 'white') {
            $text_color  = 'text-white';
            $arrow_color = get_template_directory_uri() . '/assets/imgs/Arrow.svg';
        } elseif ($item['text_color'] === 'black') {
            $text_color  = 'text-black';
            $arrow_color = get_template_directory_uri() . '/assets/imgs/Arrow-black.svg';
        }

        return [$bg_color, $text_color, $arrow_color];
    };

    // ── Helper: render a single card ─────────────────────────────────────────
    $render_card = function(array $item, string $size_class, string $extra_class = '') use ($resolve) {
        [$bg_color, $text_color, $arrow_color] = $resolve($item);
        $has_image = $item['bg_image'] !== '';
        $bg_style  = $has_image
            ? 'style="background-image:url(' . $item['bg_image'] . ');background-position:50% 50%;background-size:cover;background-repeat:no-repeat;"'
            : '';
        ?>
        <div class="<?= $text_color ?> <?= $size_class ?> <?= $extra_class ?> collection-item <?= !$has_image ? $bg_color : '' ?>" <?= $bg_style ?>>
            <a href="<?= $item['link_path'] ?>"
               class="<?= !$has_image ? 'color-bg-hover' : 'collection-gradient-box' ?> flex flex-col justify-end w-full h-full px-6 py-10 relative">

                <div class="mb-[32px] md:mb-[40px] flex flex-col relative z-20 items-start <?= $item['icon'] !== '' ? '' : 'pt-[88px]' ?> gap-5 self-stretch w-full flex-[0_0_auto]">
                    <?php if ($item['icon'] !== '') : ?>
                        <img class="relative w-[70px] h-[70px] object-contain" src="<?= $item['icon'] ?>" alt="icon" />
                    <?php endif; ?>
                    <p class="relative font-heading text-[20px] md:text-[24px] max-w-[406px] tracking-[-2%] leading-7 md:leading-8">
                        <?= $item['title'] ?>
                    </p>
                </div>

                <p class="inline-flex z-20 gap-2 relative flex-[0_0_auto]">
                    <span class="relative w-fit uppercase font-heading font-semibold text-base text-center tracking-[0] leading-6 md:leading-[18px] whitespace-nowrap">
                        <?= $item['link_label'] ?>
                    </span>
                    <img class="relative w-4 h-4 max-[600px]:mt-[3px] arrow" src="<?= $arrow_color ?>" alt="arrow" />
                </p>

            </a>
        </div>
        <?php
    };

    // ── Grid/flex class (only used for 1–4 col) ──────────────────────────────
    switch ($item_count) {
        case 1:
            $grid_class = 'grid grid-cols-1 gap-5';
            break;
        case 2:
            $grid_class = 'grid grid-cols-1 lg:[grid-template-columns:75fr_59fr] gap-5';
            break;
        case 3:
            $grid_class = 'grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-2 gap-5';
            break;
        case 4:
            $grid_class = 'flex flex-wrap gap-5';
            break;
        default:
            $grid_class = '';
            break;
    }
?>

    <div class="flex-col items-start w-full flex-[0_0_auto] flex relative">

        <?php if ($item_count === 5) : ?>
        <!-- ── 5-col: custom nested flex ──────────────────────────────────── -->
        <!--
             Desktop layout:
             ┌──────────┬──────────────────┬──────────┐
             │          │   item2 (wide)   │ item3(nw)│  row 1
             │  item1   ├──────────┬───────────────────┤
             │  (tall)  │ item4(nw)│   item5 (wide)   │  row 2
             └──────────┴──────────┴───────────────────┘

             item2 & item5 → flex-1 (same width ✓)
             item3 & item4 → w-[30%] (same width ✓)
        -->
        <div class="flex flex-col lg:flex-row gap-5 w-full">

            <!-- Item 1: tall left panel -->
            <?php $render_card(
                $five_items[0],
                'w-full lg:w-[calc(33%-10px)] h-[380px] lg:h-[800px]'
            ); ?>

            <!-- Right side: two rows -->
            <div class="flex flex-col gap-5 flex-1">

                <!-- Row 1: item2 (wide) + item3 (narrow) -->
                <div class="flex flex-col md:flex-row gap-5">
                    <?php $render_card($five_items[1], 'md:flex-1 h-[380px] md:h-[390px]'); ?>
                    <?php $render_card($five_items[2], 'w-full md:w-[44%] h-[380px] lg:h-[390px]'); ?>
                </div>

                <!-- Row 2: item4 (narrow) + item5 (wide) -->
                <div class="flex flex-col md:flex-row gap-5">
                    <?php $render_card($five_items[3], 'w-full md:w-[44%] h-[380px] lg:h-[390px]'); ?>
                    <?php $render_card($five_items[4], 'md:flex-1 h-[380px] lg:h-[390px]'); ?>
                </div>

            </div>
        </div>

        <?php else : ?>
        <!-- ── 1–4 col: standard loop ─────────────────────────────────────── -->
        <div class="<?= $grid_class ?> w-full">

            <?php if (have_rows('items')) : while (have_rows('items')) : the_row();
                $item_index++;

                // Span / width classes
                $span_class = '';
                if ($item_count === 4) {
                    $wide   = 'flex-none w-full md:w-[calc(56%-10px)]';
                    $narrow = 'flex-none w-full md:w-[calc(44%-10px)]';
                    $span_map = [1 => $wide, 2 => $narrow, 3 => $narrow, 4 => $wide];
                    $span_class = $span_map[$item_index] ?? '';
                } elseif ($item_count === 3 && $item_index === 1) {
                    $span_class = 'lg:row-span-2';
                }

                // Height classes
                if (in_array($item_count, [1, 2])) {
                    $height_class = 'h-[380px] lg:h-[800px]';
                } elseif ($item_count === 3) {
                    $height_class = ($item_index === 1) ? 'h-[380px] lg:h-[800px]' : 'h-[380px] lg:h-[390px]';
                } else { // 4
                    $height_class = 'h-[380px] lg:h-[390px]';
                }

                // bg / text / arrow
                $bg_color  = '';
                $bg_image  = esc_url(get_sub_field('bg_image'));
                if (wp_kses_post(get_sub_field('bg_color')) == 'white')     $bg_color = 'bg-white';
                elseif (wp_kses_post(get_sub_field('bg_color')) == 'gray')  $bg_color = 'bg-[#CCCCCC]';
                elseif (wp_kses_post(get_sub_field('bg_color')) == 'blue')  $bg_color = 'bg-[#4a78ff]';

                $text_color  = '';
                $arrow_color = '';
                if (wp_kses_post(get_sub_field('text_color')) == 'white') {
                    $text_color  = 'text-white';
                    $arrow_color = get_template_directory_uri() . '/assets/imgs/Arrow.svg';
                } elseif (wp_kses_post(get_sub_field('text_color')) == 'black') {
                    $text_color  = 'text-black';
                    $arrow_color = get_template_directory_uri() . '/assets/imgs/Arrow-black.svg';
                }
            ?>

                <div class="<?= $text_color ?> <?= $span_class ?> <?= $height_class ?> collection-item <?= $bg_image === '' ? $bg_color : '' ?>"
                    <?= $bg_image !== '' ? 'style="background-image:url(' . $bg_image . ');background-position:50% 50%;background-size:cover;background-repeat:no-repeat;"' : '' ?>>

                    <a href="<?= wp_kses_post(get_sub_field('link_path')) ?>"
                       class="<?= $bg_image === '' ? 'color-bg-hover' : 'collection-gradient-box' ?> flex flex-col justify-end w-full h-full px-6 py-10 relative">

                        <div class="mb-[32px] md:mb-[40px] flex flex-col relative z-20 items-start <?= esc_url(get_sub_field('icon')) !== '' ? '' : 'pt-[88px]' ?> gap-5 self-stretch w-full flex-[0_0_auto]">
                            <?php if (esc_url(get_sub_field('icon')) !== '') : ?>
                                <img class="relative w-[70px] h-[70px] object-contain" src="<?= esc_url(get_sub_field('icon')) ?>" alt="icon" />
                            <?php endif; ?>
                            <p class="relative font-heading text-[20px] md:text-[24px] max-w-[406px] tracking-[-2%] leading-7 md:leading-8">
                                <?= wp_kses_post(get_sub_field('title')) ?>
                            </p>
                        </div>

                        <p class="inline-flex z-20 gap-2 relative flex-[0_0_auto]">
                            <span class="relative w-fit uppercase font-heading font-semibold text-base text-center tracking-[0] leading-6 md:leading-[18px] whitespace-nowrap">
                                <?= wp_kses_post(get_sub_field('link_label')) ?>
                            </span>
                            <img class="relative w-4 h-4 max-md:mt-[3px] arrow" src="<?= $arrow_color ?>" alt="arrow" />
                        </p>

                    </a>
                </div>

            <?php endwhile; endif; ?>

        </div>
        <?php endif; ?>

    </div>

<?php endwhile; endif; ?>


      </div>
    </section>
<?php endwhile; endif; ?>