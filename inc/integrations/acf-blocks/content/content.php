<?php

/**
 * faq Block Template.
 */

$id = 'content' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'content';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('content')) :  while (have_rows('content')) : the_row();

$content_block = get_sub_field('content');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<div class="wrapper">
		<?php echo $content_block; ?>
		</div>
    </section>
<?php endwhile;
endif; ?>