<?php

/**
 * Contact Form Block Template.
 */

$id = 'contact-form' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'contact-form';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('contact-form')) :  while (have_rows('contact-form')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> contact-form-sec px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="c-contact__container py-15 md:py-20 lg:py-40 px-4 min-[600px]:px-10">
        <div class="flex min-[992px]:gap-[60px] w-full max-w-[1920px]">

          <!-- LEFT -->
          <div class="c-contact__content space-y-6">
            <?php if ($title_row_1 || $title_row_2): ?>
              <h2 class="c-contact__title text-[36px] leading-[44px] tracking-[-0.02em] lg:text-[68px] lg:leading-[78px] mb-[20px]">
                <span class="font-bold"><?php echo esc_html($title_row_1); ?></span>
                <?php if ($title_row_2): ?>
                <span class="font-light"><?php echo esc_html($title_row_2); ?></span>
                <?php endif; ?>
              </h2>
            <?php endif; ?>        

            <?php if ($description): ?>
              <div class="c-contact__description text-[18] md:text[20] leading-[26] md:tracking-[28] mb-[32px] md:mb-[40px]">
                <?php echo wp_kses_post($description); ?>
              </div>
            <?php endif; ?>

            <!-- SOCIAL -->
            <?php if (have_rows('social_links')): ?>
              <div class="c-contact__social flex items-center gap-4 flex-wrap mb-[32px] pt-[20px] md:pt-6">

                <?php while (have_rows('social_links')): the_row(); 
                  $icon_id = get_sub_field('icon');
                  $link    = get_sub_field('social_link');
                ?>
                  <?php if ($link): ?>
                    <a class="c-contact__social-link mb-[16px]" href="<?php echo esc_url($link['url']); ?>"
                      target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                      class="c-contact__social-link flex items-center justify-center transition text-[18px] leading-[28px] ">
                      <?php if ($icon_id): ?>
                        <?php echo wp_get_attachment_image(
                          $icon_id,
                          'thumbnail', false, [ 'class' => 'c-contact__social-icon w-11 h-11 object-contain', 'alt' => esc_attr(get_post_meta($icon_id, '_wp_attachment_image_alt', true)) ]
                        ); ?>
                      <?php endif; ?>
                      <span><?php echo esc_html($link['title']); ?></span>
                    </a>
                  <?php endif; ?>
                <?php endwhile; ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- RIGHT -->
          <div class="c-contact__right space-y-6">
            <!-- FORM -->
            <?php if ($form_shortcode): ?>
              <div class="c-contact__form bg-white shadow-lg rounded-2xl p-6">
                <?php echo do_shortcode($form_shortcode); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>  
    </section>
<?php endwhile;
endif; ?>