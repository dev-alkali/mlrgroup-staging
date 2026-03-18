<?php

/**
 * Hero Block Template.
 */


$id = 'hero-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}


$className = 'hero';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('hero')) :  while (have_rows('hero')) : the_row(); ?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> c-hero flex flex-col w-full items-center p-0 min-[890px]:pt-5 min-[890px]:pb-0  min-[890px]:px-5 bg-white h-screen">
      <?php if (have_rows('main')) :  while (have_rows('main')) : the_row(); ?>
          <div
            class="max-w-[1920px] flex-1 w-full" style=" background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>'); background-position: 50% 20%; background-size: cover; background-repeat: no-repeat;  ">
            <div class="w-full h-full flex flex-col items-start gap-[162px] px-4 min-[600px]:px-10 min-[767px]:px-20 py-0 relative  [background:linear-gradient(0deg,rgba(0,0,0,0.35)_0%,rgba(0,0,0,0.35)_100%)]">
              <div class="flex flex-col items-start justify-end pt-8 pb-20 min-[600px]:pb-16 px-0 relative flex-1 w-full ">

                
                  <!-- HERO CONTENT -->
                  <div class="flex flex-col items-start justify-center gap-10 w-full ">
                    <div class="flex flex-col items-start justify-center gap-5 w-full">
                      <?php if (have_rows('title_group')) : while (have_rows('title_group')) : the_row(); ?>
                          <h1 class="c-hero__title max-w-[936px] font-bold text-[44px] min-[600px]:text-[64px] min-[767px]:text-[70px] min-[1200px]:text-[90px] tracking-[-2%] leading-[56px] min-[600px]:leading-[60px] min-[767px]:leading-[76px] min-[1200px]:leading-[106px] text-white font-heading anim"  data-delay="0.1" data-anim="up" >
                            <span id="text-element" class="flex items-center">
                              <?php
                              $is_first = true;
                              if (have_rows('titles_row_1_change')) : while (have_rows('titles_row_1_change')) : the_row(); ?>
                                  <span class="title " style="display: <?php echo $is_first ? 'inline-block' : 'none'; ?>;">
                                    <?= wp_kses_post(get_sub_field('title')) ?>
                                  </span>
                              <?php
                                  $is_first = false;
                                endwhile;
                              endif; ?>

                            </span>
                            <span class="inline">
                              <?= wp_kses_post(get_sub_field('title_row_2')) ?><span class="text-accent">.</span>
                            </span>
                          </h1>
                      <?php endwhile;
                      endif; ?>
                      <p class="c-hero__subtitle max-w-[800px] text-[18px] min-[600px]:text-xl leading-[26px] min-[600px]:leading-7 text-gray-50 font-body anim" data-delay="1.2" data-anim="up">
                        <?= wp_kses_post(get_sub_field('subtitle')) ?>
                      </p>
                    </div>

                    <a href="<?= wp_kses_post(get_sub_field('btn_path')) ?>"
                      class="c-hero__button btn-primary anim" data-delay="2" data-anim="up">
                      <?= wp_kses_post(get_sub_field('btn_label')) ?>
                    </a>
                  </div>
              </div>
            </div>
          </div>
      <?php endwhile;
      endif; ?>

      <?php if (have_rows('brands')) :  while (have_rows('brands')) : the_row(); ?>
          <section class="c-brands flex items-center gap-2 pl-4 pr-4 min-[890px]:pl-[58px] min-[890px]:pr-0 py-10  w-full wrapper bg-white">
            <div class="flex flex-col min-[890px]:flex-row items-center gap-4 min-[600px]:gap-[30px] min-[890px]:gap-[105px] relative w-full ">
              <div class="flex items-start min-[600px]:justify-start justify-center gap-2 min-[600px]:gap-3 shrink-0">
                <div class="relative mt-[1.5px] min-[600px]:mt-[3px]">
                  <img class="w-4 min-[600px]:w-5 " src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow">

                </div>

                <p class="c-brands__desc text-[16px] font-medium min-[600px]:text-2xl min-[600px]:tracking-[-2%] leading-6 min-[600px]:leading-8 text-black font-heading">
                  <?= wp_kses_post(get_sub_field('title')) ?>
                </p>
              </div>

              <!-- MARQUEE -->
              <div class="flex-1  overflow-hidden relative h-[91.15px] md:h-auto">
                <div class="absolute -top-4 left-[-7%] w-[133px] max-[890px]:hidden h-[139px] bg-white z-20 blur-[16px]"></div>
                <div class="absolute -top-4 right-[-12%] w-[133px] h-[139px] max-[890px]:hidden bg-white z-20  blur-[16px]"></div>
                <div class="marquee-wrapper overflow-hidden w-full">
                  <div class="marquee-track relative">
                    <div class="marquee-group">
                      <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                          <img class="c-brands__logo h-[91.15px] gray-icon w-auto max-w-none block" src="<?= esc_url(get_sub_field('image')) ?>" alt="Brand logos" />
                      <?php endwhile;
                      endif; ?>
                    </div>
                    <div class="marquee-group" aria-hidden="true">
                      <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                          <img class="h-[91.15px] gray-icon w-auto max-w-none block" src="<?= esc_url(get_sub_field('image')) ?>" alt="Brand logos" />
                      <?php endwhile;
                      endif; ?>
                    </div>

                  </div>
                </div>
                <svg style="width:0; height:0; position:absolute;" aria-hidden="true" focusable="false">
                  <filter id="gray-color">
                    <feColorMatrix type="matrix" values=" 
                      0 0 0 0 0.5
                      0 0 0 0 0.5
                      0 0 0 0 0.5
                      0 0 0 1 0
                    " />
                  </filter>
                </svg>
              </div>
          <?php endwhile;
      endif; ?>


            </div>
          </section>
    </section>
<?php endwhile;
endif; ?>