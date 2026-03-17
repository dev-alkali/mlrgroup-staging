<?php

/**
 * Client Logos Block Template.
 */

$id = 'client-logos-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'client-logos';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('client-logos')) : ?>
  <?php while (have_rows('client-logos')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center">
      <div class="flex flex-col w-full items-start gap-8 min-[600px]:gap-[60px] max-w-[1920px]">

        <?php if (have_rows('header_content')) : ?>
          <?php while (have_rows('header_content')) : the_row(); ?>
            <div class="">
              <?php 
                $title1 = get_sub_field('title_row_1');
                $title2 = get_sub_field('title_row_2');
                $subtitle = get_sub_field('subtitle');
              ?>

              <?php if ($title1 || $title2) : ?>
                <h2 class="text-[44px] min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-0.02em] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px] font-heading">
                  <span class="font-bold text-neutral-800"><?php echo wp_kses_post($title1); ?></span>
                  <span class="font-light text-neutral-500"><?php echo wp_kses_post($title2); ?></span>
                </h2>
              <?php endif; ?>

              <?php if ($subtitle) : ?>
                <p class="text-xl leading-7 text-neutral-600 font-body">
                  <?php echo wp_kses_post($subtitle); ?>
                </p>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if (get_field('filter_display')) : ?>
        <div class="">

           <?php if (have_rows('logo_lists')) : ?>
                  <?php while (have_rows('logo_lists')) : the_row();                      
                      $logo = get_sub_field('logo_img');
                      $bg_color = get_sub_field('background_color');
                      $industry = get_sub_field('industries_filter');
                      
                    ?>

                      <div class="flex items-center justify-center p-6 <?php echo esc_attr($bg_color); ?>">

                        <?php if ($logo) : ?>
                          <img 
                            src="<?php echo esc_url($logo['url']); ?>" 
                            alt="<?php echo esc_attr($logo['alt']); ?>" 
                            class="max-w-full h-auto"
                          />
                        <?php endif; ?>

                      </div>

                    <?php endwhile; ?>
                  <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="logo-card">
                 <?php if (have_rows('logo_lists')) : ?>
                  <?php while (have_rows('logo_lists')) : the_row();                      
                      $logo = get_sub_field('logo_img');
                      $bg_color = get_sub_field('background_color');
                      $industry = get_sub_field('industries_filter');
                      
                    ?>

                      <div class="flex items-center justify-center p-6 <?php echo esc_attr($bg_color); ?>">

                        <?php if ($logo) : ?>
                          <img 
                            src="<?php echo esc_url($logo['url']); ?>" 
                            alt="<?php echo esc_attr($logo['alt']); ?>" 
                            class="max-w-full h-auto"
                          />
                        <?php endif; ?>
                          <h2><?php echo esc_html($industry); ?></h2> 
                      </div>

                    <?php endwhile; ?>
                  <?php endif; ?>
        </div>

      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?> 