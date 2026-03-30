<?php

/**
 * Lookbooks List Block Template.
 */

$id = 'lookbooks-list' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'lookbooks-list';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('lookbooks-list')) :  while (have_rows('lookbooks-list')) : the_row(); ?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> look-sec px-4 md:px-10 pt-[40px] md:pt-[65px]">
      <div class="gap-[30px] md:gap-[0px] w-full wrapper">     

        <?php if ( have_rows( 'lookbooks' ) ) : ?>
          <?php while ( have_rows( 'lookbooks' ) ) : the_row(); ?>
          <?php $year = get_sub_field( 'year' ); ?>
      <div class="lookbook-year mb-[25px] md:mb-[45px]">

        <h2 class="font-[poppins] font-bold text-[#262626] leading-[clamp(44px,4vw,60px)] text-[clamp(36px,5vw,60px)] tracking-[-0.02em] mb-[17px] md:mb-[21px] flex ga-[12px] md:gap-[16px]"><img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" alt="" class="w-[35px] h-[35px] md:w-[62px] md:h-[62px]"> <?php echo esc_html( $year ); ?></h2>

        <?php if ( have_rows( 'l_lists' ) ) : ?>
          <div class="lookbook-list columns-1 md:columns-2 md:gap-x-[40px]">

            <?php while ( have_rows( 'l_lists' ) ) : the_row(); ?>

              <?php
                $image   = get_sub_field( 'image' );    // single image array
                $title   = get_sub_field( 'title' );
                $session = get_sub_field( 'session' );  // select value
                $link    = get_sub_field( 'link' );     // URL string
              ?>

              <div class="lookbook-item break-inside-avoid mb-[32px] md:mb-[40px]">

                <!-- Image -->
                <?php if ( ! empty( $image ) ) : ?>
                  <div class="lookbook-images mb-[16px] relative">
                    <img
                      src="<?php echo esc_url( $image['url'] ); ?>"
                      alt="<?php echo esc_attr( $image['alt'] ); ?>"
                      width="100%"
                      height="<?php echo esc_attr( $image['height'] ); ?>"
                    />
                    <!-- Link (URL) -->
                    <?php if ( $link ) : ?>
                      <a class="lookbook-link absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center gap-3 opacity-0 hover:opacity-100 transition-all duration-300 ease-in-out bg-[linear-gradient(318.51deg,rgba(0,0,0,0.8)-57.23%,rgba(253,67,56,0.8)105.13%)]" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?= get_template_directory_uri() ?>/assets/imgs/arrow-with-white-bg.png" alt="" class="w-[52px] h-[52px] md:w-[56px] md:h-[56px]">
                        <span class="font-poppins font-medium uppercase text-white text-[clamp(16px,4vw,18px)] leading-[clamp(18px,4.5vw,20px)]">View Lookbook</span>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

                <!-- Title -->
                <?php if ( $title ) : ?>
                  <h3 class="lookbook-title font-[poppins] font-bold text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] mb-[8px] "><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>

                <!-- Session (select) -->
                <?php if ( $session ) : ?>
                  <h4 class="lookbook-session font-forma font-normal text-[#525252] text-[clamp(14px,1.2vw,16px)] leading-[20px] border border-[#525252] rounded-[30px] shadow-[0px_1px_2px_0px_#0A0D120D] inline-flex px-[16px] pt-[6px] pb-[4px]"><?php echo esc_html( $session ); ?> <?php echo esc_html( $year ); ?></h4>
                <?php endif; ?>
              </div><!-- .lookbook-item -->
            <?php endwhile; ?>
          </div><!-- .lookbook-list -->
        <?php endif; ?>
      </div><!-- .lookbook-year -->
    <?php endwhile; ?>
  <?php endif; ?>






      </div>
    </section>
<?php endwhile;
endif; ?>


