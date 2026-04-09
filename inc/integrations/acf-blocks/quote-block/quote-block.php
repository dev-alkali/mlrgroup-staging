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
$multiple_arrows = get_sub_field('multiple_arrows');

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
		<div class="wrapper ">
        <?php if($arrow_display): ?>
          <div class="arrow-display md:mb-[28px] mb-[18px]">
            <?php if($multiple_arrows): ?>
              <img src="<?= get_template_directory_uri() ?>/assets/imgs/seven-arrows-img.svg" alt="" class="md:max-w-[421px] max-w-[300px] w-full">
            <?php else: ?>
              <img src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-red.svg" alt="" class="w-[35px] h-[35px] md:w-[42px] md:h-[42px]">
            <?php endif; ?>
          </div>
        <?php endif; ?>
		<div class="quote-content md:pb-[28px] pb-[20px] border-b border-b-[6px] border-[#FD4338] tracking-[-2%] font-heading">
        <?php echo $quote; ?>
        </div>
		</div>
    </section>
<?php endwhile;
endif; ?>