<?php

/**
 * multiple Images Block Template.
 */

$id = 'multiple-images' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'multiple-images';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('multiple-images')) :  while (have_rows('multiple-images')) : the_row();

$images = get_sub_field('images');

$section_remove_top_padding    = get_sub_field('section_remove_top_padding');
$section_remove_bottom_padding = get_sub_field('section_remove_bottom_padding');

$pt_class = '';
if ( ! empty( $section_remove_top_padding ) ) {
    $pt_class = ' ' . 'pt0';
}

$pb_class = '';
if ( ! empty( $section_remove_bottom_padding ) ) {
    $pb_class = ' ' . 'pb0';
}

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>-sec<?php echo $pt_class; ?><?php echo $pb_class; ?>">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<div class="flex flex-wrap gap-[20px] md:flex-nowrap md:flex-row flex-col">
      <?php foreach($images as $image): 
        $main_image = $image['main_image'];
        $image_alt = $image['alt'] ?? '';
        ?>
        <div class="w-full md:flex-1 flex">
          <img class="w-full md:max-h-[unset] max-h-[400px] object-cover" src="<?php echo esc_url($main_image['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">
        </div>
      <?php endforeach; ?>
		</div>
    </section>
<?php endwhile;
endif; ?>