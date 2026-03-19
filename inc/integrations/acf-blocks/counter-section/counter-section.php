<?php

/**
 * Counter Section Block Template.
 */

$id = 'counter-section-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'counter-section';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>

<?php if (have_rows('counter-section')) : ?>
  <?php while (have_rows('counter-section')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> performance flex justify-center  px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="w-full wrapper">
        <div class="flex items-center justify-between md:justify-evenly lg:justify-between gap-8 md:gap-4 max-[1440px]:flex-wrap flex-1">
            <?php if (have_rows('counter_list')) :  while (have_rows('counter_list')) : the_row(); ?>
                    <div class="performance-item inline-flex flex-col max-[567px]:max-w-[163px] max-[567px]:w-full  w-max min-[567px]:items-center gap-1 min-[600px]:gap-3">
                        <div class="relative flex items-center justify-items-start min-[567px]:justify-center text-[40px] min-[600px]:text-[50px] min-[890px]:text-6xl leading-[48px] min-[600px]:leading-[52px] font-bold tracking-[-2%] font-[poppins]">
                            <div class="invisible text-[#262626]" aria-hidden="true">
                                <?= wp_kses_post(get_sub_field('value')) ?>
                            </div>

                            <div class="absolute count-box tabular-nums text-[#262626]">
                                <?= wp_kses_post(get_sub_field('value')) ?>
                            </div>
                        </div>
                        <p class="min-[567px]:max-w-[133px] text-[14px] min-[600px]:text-base leading-[20px] min-[600px]:leading-6  text-[##525252] font-body min-[567px]:text-center">
                            <?= wp_kses_post(get_sub_field('description')) ?>
                        </p>
                    </div>
            <?php endwhile;
            endif; ?>

        </div>

      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?> 