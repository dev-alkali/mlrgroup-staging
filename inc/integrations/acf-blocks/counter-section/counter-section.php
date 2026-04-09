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
  <?php while (have_rows('counter-section')) : the_row();

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

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> performance flex justify-center  px-4 md:px-10 pb-[60px] md:pb-[120px]<?php echo $pt_class; ?><?php echo $pb_class; ?>">
      <div class="w-full wrapper grid grid-cols-2 lg:grid-cols-4 gap-[30px]">
            <?php if (have_rows('counter_list')) :  while (have_rows('counter_list')) : the_row(); ?>
              <div class="performance-item flex flex-col items-start md:items-center w-full md:gap-[30px]">
                  <div class="relative flex items-center justify-start sm:justify-center text-[clamp(40px,5vw,64px)] leading-[clamp(48px,5.5vw,72px)] font-bold tracking-[-0.02em] font-[Poppins]">
                      <div class="invisible text-[#262626]" aria-hidden="true"><?= wp_kses_post(get_sub_field('value')) ?></div>
                      <div class="absolute count-box tabular-nums text-[#262626]"><?= wp_kses_post(get_sub_field('value')) ?></div>
                  </div>
                  <p class="text-[14px] min-[600px]:text-base leading-[20px] md:leading-6  text-[#525252] font-body md:text-center"><?= wp_kses_post(get_sub_field('description')) ?></p>
              </div>
            <?php endwhile; endif; ?>
      </div>
    </section>
  <?php endwhile; ?>
<?php endif; ?> 





