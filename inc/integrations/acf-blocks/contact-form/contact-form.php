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

$form_shortcode = get_sub_field('form_shortcode');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> contact-form-sec px-4 md:px-10 py-[60px] md:py-[120px]">
      	<div class="c-contact__container">
        	<div class="flex min-[992px]:gap-[40px] min-[1440px]:gap-[60px] w-full wrapper flex-col md:flex-row">
				<!-- LEFT -->
				<div class="w-full md:w-1/2 c-contact__content anim" data-anim="up" >
					<?php if ($title_row_1 || $title_row_2): ?>
					<h2 class="c-contact__title text-[36px] leading-[44px] tracking-[-0.02em] lg:text-[68px] lg:leading-[78px] mb-[20px]">
						<span class="font-bold"><?php echo $title_row_1; ?></span>
						<?php if ($title_row_2): ?>
						<span class="font-light text-[#ccc]"><?php echo $title_row_2; ?></span>
						<?php endif; ?>
					</h2>
					<?php endif; ?>

					<?php if ($description): ?>
					<div class="c-contact__description text-lg md:text-xl leading-[26px] md:leading-[28px] mb-8 md:mb-10 text-neutral-600">
						<?php echo wp_kses_post($description); ?>
					</div>
					<?php endif; ?>

					<!-- SOCIAL -->
					<?php if (have_rows('social_links')): ?>
					<div class="c-contact__social mb-[32px] pt-[20px] md:pt-6 flex flex-col gap-[20px]">

						<?php while (have_rows('social_links')): the_row(); 
						$icon_id = get_sub_field('icon');
						$link    = get_sub_field('social_link');
						?>
						<?php if ($link): ?>
							<a class="c-contact__social-link flex items-center flex-wrap gap-[8px]" href="<?php echo esc_url($link['url']); ?>"
							target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
							<?php if ($icon_id): ?>
								<?php echo wp_get_attachment_image(
								$icon_id,
								'thumbnail', false, [ 'class' => 'c-contact__social-icon w-[15px] h-[15px] object-contain', 'alt' => esc_attr(get_post_meta($icon_id, '_wp_attachment_image_alt', true)) ]
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
				<?php if ($form_shortcode): ?>
					<div class="w-full md:w-1/2 c-contact__right anim" data-anim="up" data-delay=".5" >
						<div class="c-contact__form">
							<?php echo do_shortcode($form_shortcode); ?>
						</div>
					</div>
				<?php endif; ?>
        	</div>
      	</div>  
    </section>
<?php endwhile;
endif; ?>