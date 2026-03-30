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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> look-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col  items-center">     

        <?php if ( have_rows( 'lookbooks' ) ) : ?>
          <?php while ( have_rows( 'lookbooks' ) ) : the_row(); ?>
          <?php $year = get_sub_field( 'year' ); ?>
      <div class="lookbook-year">
        <h2><?php echo esc_html( $year ); ?></h2>

        <?php if ( have_rows( 'l_lists' ) ) : ?>
          <div class="lookbook-list">

            <?php while ( have_rows( 'l_lists' ) ) : the_row(); ?>

              <?php
                $image   = get_sub_field( 'image' );    // single image array
                $title   = get_sub_field( 'title' );
                $session = get_sub_field( 'session' );  // select value
                $link    = get_sub_field( 'link' );     // URL string
              ?>

              <div class="lookbook-item">

                <!-- Image -->
                <?php if ( ! empty( $image ) ) : ?>
                  <div class="lookbook-images">
                    <img
                      src="<?php echo esc_url( $image['url'] ); ?>"
                      alt="<?php echo esc_attr( $image['alt'] ); ?>"
                      width="<?php echo esc_attr( $image['width'] ); ?>"
                      height="<?php echo esc_attr( $image['height'] ); ?>"
                    />
                  </div>
                <?php endif; ?>

                <!-- Title -->
                <?php if ( $title ) : ?>
                  <h3 class="lookbook-title"><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>

                <!-- Session (select) -->
                <?php if ( $session ) : ?>
                  <span class="lookbook-session"><?php echo esc_html( $session ); ?></span>
                <?php endif; ?>

                <!-- Link (URL) -->
                <?php if ( $link ) : ?>
                  <a class="lookbook-link" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">View Lookbook</a>
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


