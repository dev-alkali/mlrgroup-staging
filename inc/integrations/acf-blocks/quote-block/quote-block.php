<?php

/**
 * content Block Template.
 */

$id = 'quote-block' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'quote-block';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('quote-block')) :  while (have_rows('quote-block')) : the_row();

$quote = get_sub_field('quote');
$arrow_display = get_sub_field('arrow_display');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>-sec ">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<div class="wrapper ">
        <?php if($arrow_display): ?>
          <div class="arrow-display">
            <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" alt="">
          </div>
        <?php endif; ?>
		<div class="quote-content pb-[28px] border-b border-[#FD4338]">
        <?php echo $quote; ?>
        </div>
		</div>
    </section>
<?php endwhile;
endif; ?>