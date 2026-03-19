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

// $title_row_1 = get_sub_field('title_row_1');
// $title_row_2 = get_sub_field('title_row_2');
// $description = get_sub_field('description');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> contact-form-sec px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="w-full wrapper">

      </div>
    </section>
<?php endwhile;
endif; ?>