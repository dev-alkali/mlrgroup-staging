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

<?php if (have_rows('award_winning_logo')) : while (have_rows('award_winning_logo')) : the_row(); ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex flex-col w-full items-center p-0 min-[890px]:pt-5 min-[890px]:pb-0 min-[890px]:px-5 bg-white h-screen">
  <div class="flex items-center gap-2 pl-4 pr-4 min-[890px]:pl-[58px] min-[890px]:pr-0 py-10 w-full max-w-[1920px] bg-white">
    <div class="flex flex-col min-[890px]:flex-row items-center gap-4 min-[600px]:gap-[30px] min-[890px]:gap-[105px] relative w-full">
      <div class="flex items-start min-[600px]:justify-start justify-center gap-2 min-[600px]:gap-3 shrink-0">
        <div class="relative mt-[1.5px] min-[600px]:mt-[3px]">
          <img class="w-4 min-[600px]:w-5" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow">
        </div>
        <p class="text-[16px] font-medium min-[600px]:text-2xl min-[600px]:tracking-[-2%] leading-6 min-[600px]:leading-8 text-black font-heading">
          <?= wp_kses_post(get_sub_field('title')) ?>
        </p>
      </div>

      <!-- MARQUEE -->
      <div class="flex-1 overflow-hidden relative h-[91.15px] md:h-auto">
        <div class="absolute -top-4 left-[-7%] w-[133px] max-[890px]:hidden h-[139px] bg-white z-20 blur-[16px]"></div>
        <div class="absolute -top-4 right-[-12%] w-[133px] h-[139px] max-[890px]:hidden bg-white z-20 blur-[16px]"></div>

        <div class="marquee-wrapper overflow-hidden w-full">
          <div class="marquee-track relative">
            <div class="marquee-group">
              <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                <img class="h-[91.15px] gray-icon w-auto max-w-none block"
                     src="<?= esc_url(get_sub_field('image')) ?>"
                     alt="Brand logos" />
              <?php endwhile; endif; ?>
            </div>

            <div class="marquee-group" aria-hidden="true">
              <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                <img class="h-[91.15px] gray-icon w-auto max-w-none block"
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