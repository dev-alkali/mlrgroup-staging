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
<?php if (have_rows('case_studies')) :  while (have_rows('case_studies')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-[120px] bg-white">
      <div class="flex flex-col w-full items-start gap-8 min-[600px]:gap-[60px] max-w-[1920px]">
        <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>

            <div class="flex flex-col  items-start gap-5 relative ">
              <h2
                class=" flex flex-col font-heading text-[44px] min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-2%] max-w-[700px] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px]">
                <span class="font-bold text-neutral-800 "><?= wp_kses_post(get_sub_field('title_row_1')) ?> </span>
                <span class="font-light text-neutral-500 "><?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
              </h2>
              <p
                class=" font-body  text-neutral-600 text-xl tracking-[0] leading-7">
                <?= wp_kses_post(get_sub_field('paragraph')) ?>
              </p>

            </div>
        <?php endwhile;
        endif; ?>

        <?php /* if (have_rows('main_content')) :  while (have_rows('main_content')) : the_row(); ?>
            <div class="flex-col items-start max-[600px]:gap-6 max-[1024px]:gap-10 w-full flex-[0_0_auto] flex relative">              
                  <div class="flex flex-col min-[1024px]:flex-row max-[600px]:gap-6 max-[1024px]:gap-10 items-start relative min-[1441px]:aspect-[1440/409] max-[1441px]:h-[409px] max-[1024px]:h-auto w-full collection-parent">
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
                    <?php endwhile; endif; ?>
                  </div>
            </div>
        <?php endwhile; endif; */ ?>





<?php if (have_rows('main_content')) : while (have_rows('main_content')) : the_row();

    $items      = get_sub_field('items');
    $item_count = is_array($items) ? count($items) : 0;
    $item_index = 0;

    /*
     * ┌─────────────────────────────────────────────────────────┐
     *  Layout rules per item count
     *
     *  1 item  → 1 col  | item1: desktop 800px  / mobile 380px
     *  2 items → 2 cols | all:   desktop 800px  / mobile 380px | gap 20px
     *  3 items → 2 cols | item1: desktop 800px (row-span-2)     | gap 20px
     *                   | item2+3: desktop 390px
     *  4 items → 2 cols | all:   desktop 390px  / mobile 380px  | gap 20px
     *  5 items → 6 cols | item1: desktop 800px (col-span-2 row-span-2) / mobile 380px
     *                   | item2-5: desktop 390px                | gap 20px
     * └─────────────────────────────────────────────────────────┘
     */

    switch ($item_count) {
        case 1:
            $grid_class = 'grid grid-cols-1 gap-5';
            break;
        case 2:
            // 750:590 ratio → 75fr : 59fr
            $grid_class = 'grid max-[1024px]:grid-cols-1 min-[1024px]:[grid-template-columns:75fr_59fr] gap-5';
            break;
        case 3:
            $grid_class = 'grid max-[1024px]:grid-cols-1 min-[1024px]:grid-cols-2 min-[1024px]:grid-rows-2 gap-5';
            break;
        case 4:
            /*
             * 4-col grid so widths flip between rows:
             *   Row 1: [Item1 col-span-3 WIDE ] [Item2 col-span-1 NARROW]
             *   Row 2: [Item3 col-span-1 NARROW] [Item4 col-span-3 WIDE ]
             */
            $grid_class = 'grid max-[600px]:grid-cols-1 min-[600px]:grid-cols-2 min-[1024px]:grid-cols-4 min-[1024px]:grid-rows-2 gap-5';
            break;
        case 5:
        default:
            $grid_class = 'grid max-[600px]:grid-cols-1 min-[600px]:grid-cols-2 min-[1024px]:grid-cols-6 min-[1024px]:grid-rows-2 gap-5';
            break;
    }
?>

    <div class="flex-col items-start w-full flex-[0_0_auto] flex relative">
        <div class="<?= $grid_class ?> w-full">

            <?php if (have_rows('items')) : while (have_rows('items')) : the_row();
                $item_index++;

                // ── Span classes ─────────────────────────────────────────────
                $span_class = '';

                if ($item_count === 5) {
                    $span_map = [
                        1 => 'min-[1024px]:col-span-2 min-[1024px]:row-span-2',
                        2 => 'min-[1024px]:col-span-3',
                        3 => 'min-[1024px]:col-span-1',
                        4 => 'min-[1024px]:col-span-1',
                        5 => 'min-[1024px]:col-span-3',
                    ];
                    $span_class = $span_map[$item_index] ?? '';
                } elseif ($item_count === 4) {
                    $span_map = [
                        1 => 'min-[1024px]:col-span-3',
                        2 => 'min-[1024px]:col-span-1',
                        3 => 'min-[1024px]:col-span-1',
                        4 => 'min-[1024px]:col-span-3',
                    ];
                    $span_class = $span_map[$item_index] ?? '';
                } elseif ($item_count === 3 && $item_index === 1) {
                    $span_class = 'min-[1024px]:row-span-2';
                }

                // ── Height classes ───────────────────────────────────────────
                /*
                 *  1 item        → all: 380px mobile / 800px desktop
                 *  2 items       → all: 380px mobile / 800px desktop
                 *  3 items       → item1: 380px mobile / 800px desktop
                 *                  item2+: 380px mobile / 390px desktop
                 *  4 items       → all: 380px mobile / 390px desktop
                 *  5 items       → item1: 380px mobile / 800px desktop
                 *                  item2+: 380px mobile / 390px desktop
                 */
                if ($item_count === 1) {
                    $height_class = 'h-[380px] min-[1024px]:h-[800px]';
                } elseif ($item_count === 2) {
                    $height_class = 'h-[380px] min-[1024px]:h-[800px]';
                } elseif ($item_count === 3) {
                    $height_class = ($item_index === 1)
                        ? 'h-[380px] min-[1024px]:h-[800px]'
                        : 'h-[380px] min-[1024px]:h-[390px]';
                } elseif ($item_count === 4) {
                    $height_class = 'h-[380px] min-[1024px]:h-[390px]';
                } else { // 5
                    $height_class = ($item_index === 1)
                        ? 'h-[380px] min-[1024px]:h-[800px]'
                        : 'h-[380px] min-[1024px]:h-[390px]';
                }

                // ── Existing bg / text / arrow logic (unchanged) ─────────────
                $bg_color  = '';
                $bg_image  = esc_url(get_sub_field('bg_image'));

                if (wp_kses_post(get_sub_field('bg_color')) == 'white') {
                    $bg_color = 'bg-white';
                } elseif (wp_kses_post(get_sub_field('bg_color')) == 'gray') {
                    $bg_color = 'bg-[#CCCCCC]';
                } elseif (wp_kses_post(get_sub_field('bg_color')) == 'blue') {
                    $bg_color = 'bg-[#4a78ff]';
                }

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

                <div class="<?= $text_color ?> <?= $span_class ?> <?= $height_class ?> collection-item
                            <?= $bg_image === '' ? $bg_color : '' ?>"
                    <?= $bg_image !== '' ? 'style="
                        background-image: url(' . $bg_image . ');
                        background-position: 50% 50%;
                        background-size: cover;
                        background-repeat: no-repeat;"'
                    : ''; ?>>

                    <a href="<?= wp_kses_post(get_sub_field('link_path')) ?>"
                       class="<?= $bg_image === '' ? 'color-bg-hover' : 'collection-gradient-box' ?>
                              flex flex-col justify-end w-full h-full px-6 py-10 relative">

                        <div class="flex flex-col relative z-20 items-start
                                    <?= esc_url(get_sub_field('icon')) !== '' ? '' : 'pt-[88px]' ?>
                                    gap-5 self-stretch w-full flex-[0_0_auto]">

                            <?php if (esc_url(get_sub_field('icon')) !== '') : ?>
                                <img class="relative w-[70px] h-[70px] object-cover"
                                     src="<?= esc_url(get_sub_field('icon')) ?>"
                                     alt="icon" />
                            <?php endif; ?>

                            <p class="relative font-heading text-[20px] min-[600px]:text-[24px]
                                      max-w-[406px] tracking-[-2%] leading-7 min-[600px]:leading-8">
                                <?= wp_kses_post(get_sub_field('title')) ?>
                            </p>
                        </div>

                        <p class="inline-flex z-20 gap-2 relative flex-[0_0_auto]">
                            <span class="relative w-fit uppercase font-heading font-semibold
                                         text-base text-center tracking-[0] leading-6
                                         min-[600px]:leading-[18px] whitespace-nowrap">
                                <?= wp_kses_post(get_sub_field('link_label')) ?>
                            </span>
                            <img class="relative w-4 h-4 max-[600px]:mt-[3px] arrow"
                                 src="<?= $arrow_color ?>"
                                 alt="arrow" />
                        </p>

                    </a>
                </div>

            <?php endwhile; endif; ?>

        </div>
    </div>

<?php endwhile; endif; ?>




      </div>
    </section>
<?php endwhile; endif; ?>