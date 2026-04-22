<?php

/**
 * Features Section Block Template.
 */

$id = 'features-section' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'features-section';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('features_section')) :  while (have_rows('features_section')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$lists = get_sub_field('lists');

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
  <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> our-values-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] overflow-hidden <?php echo $bg_color_class; ?><?php echo $pt_class; ?><?php echo $pb_class; ?>">
      <div class="gap-[15px] md:gap-[0px] w-full wrapper flex flex-col">
	  <?php if($title_row_1 || $title_row_2 ): ?>
			<div class="w-full wrapper lg:mb-[70px] sm:mb-[30px] mb-[5px] overflow-visible">
				<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="xl:text-[68px] md:text-[52px] text-[36px] leading-[40px] md:leading-[62px] xl:leading-[76px] tracking-[-2%] text-[#262626] font-heading lg:mb-[20px] relative heading-our-values">
					<?php if($title_row_1): ?>
						<span class="relative w-full block md:flex gap-[10px] title-our-values-1">
							<span class="font-bold bg-white pr-[5px] "><?= wp_kses_post($title_row_1) ?></span>
						</span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="relative w-full block md:flex gap-[10px] title-our-values-2">
							<span class="font-bold pr-[5px] bg-white"><?= wp_kses_post($title_row_2) ?></span>
						</span>
					<?php endif; ?>
				</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if($lists): ?>
			<?php $list_count = count($lists); ?>
			<div class="flex flex-wrap xl:gap-x-[70px] md:gap-y-[90px] lg:gap-x-[30px] gap-x-[20px] sm:gap-y-[40px] gap-y-[40px] justify-center">
				<?php foreach($lists as $list): 
					$heading = $list['heading'];
					$content = $list['content'];
					if ($list_count === 1) {
						$width_class = 'w-full';
					} elseif ($list_count === 2) {
						$width_class = 'xl:w-[calc(50%-30px)] md:w-[calc(50%-15px)] w-full';
					} else {
						$width_class = 'xl:w-[calc(33.33%-47px)] md:w-[calc(50%-15px)] w-full';
					}
					?>
					<div class="flex flex-row md:gap-[20px] gap-[16px] <?php echo $width_class; ?>">
						<div class="flex flex-col flex-1 red-line pb-[25px] relative">
							<?php if($heading): ?>
								<h3 class="text-[clamp(20px,2.6vw,28px)] leading-[clamp(28px,3.2vw,36px)] tracking-[-2%] text-[#262626] font-heading font-bold mb-[12px] md:pt-[10px] pt-[8px]"><?php echo $heading; ?></h3>
							<?php endif; ?>
							<?php if($content): ?>
								<div class="text-[18px] leading-[26px] text-[#525252] font-body tracking-[0px]"><?php echo $content; ?></div>
							<?php endif; ?>
							
							<img class="w-4 md:w-[23px] md:h-[23px] absolute right-0 bottom-[0px]" src="<?= get_template_directory_uri() ?>/assets/imgs/red-arrow-feature-sec.svg" alt="arrow">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
      </div>
    </section>
<?php endwhile;
endif; ?>