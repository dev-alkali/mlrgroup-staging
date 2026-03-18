<?php

/**
 * Trusted Brand Block Template.
 */


$id = 'trusted_brand-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}


$className = 'trusted_brand';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>


<?php if (have_rows('trusted_brand')) :  while (have_rows('trusted_brand')) : the_row(); ?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>min-[1024px]:pt-10 min-[1025px]:pb-10  min-[1024px]:px-5">
      <div class="flex items-center gap-2 pl-4 pr-4 py-10 w-full wrapper relative">
        <?php if (have_rows('brands')) :  while (have_rows('brands')) : the_row(); ?>          
            <div class="flex items-start min-[767px]:justify-start justify-center gap-2 min-[767px]:gap-3 shrink-0 mb-[50px]">
              <div class="relative mt-[1.5px] min-[767px]:mt-[3px]"><img class="w-4 min-[767px]:w-5 " src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow"></div>
              <p class="text-[16px] font-medium min-[767px]:text-[32px] min-[767px]:tracking-[-2%] leading-6 min-[767px]:leading-8 text-black font-heading"><?= wp_kses_post(get_sub_field('title')) ?></p>
            </div>
        <!-- MARQUEE -->
            <div class="flex-1  overflow-hidden relative h-[91.15px] md:h-auto">
              <div class="absolute -top-4 left-[-3%] w-[133px] max-[1024px]:hidden h-[139px] bg-white z-20 blur-[16px]"></div>
              <div class="absolute -top-4 right-[-3%] w-[133px] h-[139px] max-[1024px]:hidden bg-white z-20  blur-[16px]"></div>
              <div class="marquee-wrapper overflow-hidden w-full">
                <div class="marquee-track relative">
                  <div class="marquee-group">
                    <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                        <img class="h-[91.15px] gray-icon w-auto max-w-none block" src="<?= esc_url(get_sub_field('image')) ?>" alt="Brand logos" />
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
              <svg style="width:0; height:0; position:absolute;" aria-hidden="true" focusable="false"><filter id="gray-color"><feColorMatrix type="matrix" values="0 0 0 0 0.5 0 0 0 0 0.5 0 0 0 0 0.5 0 0 0 1 0" /></filter></svg>
          </div>
        <?php endwhile; endif; ?>           
      </div>
    </section>

<?php endwhile;
endif; ?>