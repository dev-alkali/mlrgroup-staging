<?php

/**
 * Award Winning Logo Block Template.
 */


$id = 'award-winning-logo-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

 
$className = 'award-winning-logo';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('award_winning_logo')) : while (have_rows('award_winning_logo')) : the_row(); 

  $section_remove_top_padding   = get_sub_field('section_remove_top_padding');
  $section_remove_bottom_padding  = get_sub_field('section_remove_bottom_padding');

  $pt_class = '';
  if ( ! empty( $section_remove_top_padding ) ) {
      $pt_class = ' ' . 'pt0' . '';
  }

  $pb_class = '';
  if ( ! empty( $section_remove_bottom_padding ) ) {
      $pb_class = ' ' . 'pb0' . '';
  }

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> p-0 py-[40px] px-[0px] md:px-[20px] md:py-[60px] <?php echo $pt_class; ?><?php echo $pb_class; ?>">
  <div class="flex items-center gap-2 wrapper">
    <div class="flex flex-col min-[890px]:flex-row gap-4 min-[600px]:gap-[40px] min-[890px]:gap-[105px] relative w-full">
      <div class="flex items-center justify-start gap-2 min-[600px]:gap-3 shrink-0 px-[20px] md:px-[0px]">
        <div class="relative flex">
          <img class="w-4 min-[600px]:w-5 md:w-[27px] md:h-[27px]" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow">
        </div>
        <p class="text-[16px] font-medium min-[768px]:text-[32px] min-[600px]:tracking-[-2%] leading-6 min-[600px]:leading-8 text-black font-heading">
          <?= wp_kses_post(get_sub_field('title')) ?>
        </p>
      </div>

      <!-- MARQUEE -->
      <div class="flex-1 overflow-hidden relative h-[131px] md:h-auto">

        <div class="absolute top-[-30px] left-[-7%] w-[189px] max-[890px]:hidden h-[200px] bg-white z-20 blur-[16px]"></div>
        <div class="absolute top-[-30px] right-[-140px] w-[189px] h-[200px] max-[890px]:hidden bg-white z-20  blur-[16px]"></div>


        <div class="marquee-wrapper overflow-hidden w-full">
          <div class="marquee-track relative">
            <div class="marquee-group">
              <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                <img class="h-[131px] w-auto max-w-none block grayscale"
                     src="<?= esc_url(get_sub_field('image')) ?>"
                     alt="Brand logos" />
              <?php endwhile; endif; ?>
            </div>

            <div class="marquee-group" aria-hidden="true">
              <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                <img class="h-[131px]  w-auto max-w-none block grayscale"
                     src="<?= esc_url(get_sub_field('image')) ?>"
                     alt="Brand logos" />
              <?php endwhile; endif; ?>
            </div>
          </div>
        </div>

        <svg style="width:0; height:0; position:absolute;" aria-hidden="true" focusable="false">
          <filter id="gray-color">
            <feColorMatrix type="matrix"
              values="0 0 0 0 0.5
                      0 0 0 0 0.5
                      0 0 0 0 0.5
                      0 0 0 1 0" />
          </filter>
        </svg>
      </div>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>