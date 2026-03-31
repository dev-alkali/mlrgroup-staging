<?php

/**
 * Our Values Block Template.
 */

$id = 'our-values' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'our-values';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('our-values')) :  while (have_rows('our-values')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$lists = get_sub_field('lists');




?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> our-values-sec py-[60px] lg:py-[80px] xl:py-[120px] overflow-hidden <?php echo $bg_color_class; ?>">
      
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col">

	  <?php if($title_row_1 || $title_row_2 ): ?>
			<div class="w-full wrapper lg:mb-[70px] sm:mb-[50px] mb-[20px] overflow-visible">
				<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="xl:text-[68px] md:text-[52px] text-[36px] leading-[40px] md:leading-[62px] xl:leading-[76px] tracking-[-2%] text-[#262626] font-heading lg:mb-[20px] relative md:w-[calc(100%-40px)] ml-auto w-[calc(100%-16px)] heading-our-values">
					<!-- <div class="bg-repeat absolute top-[0px] left-[10%] right-[calc(100%+100px)] arrow-img-position w-full h-[100%]" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/our-value-arrow.svg');"></div> -->
					<?php if($title_row_1): ?>
						<span class="relative w-full block flex gap-[10px] title-our-values-1">
							<span class="font-bold bg-white pr-[5px] "><?= wp_kses_post($title_row_1) ?></span>
							<div class="flex-1 flex flex-col">
								<div class="arrow-img-position w-full flex-1 bg-repeat-x arrow-img-position-1line" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/our-value-arrow.svg');"></div>
								<div class="arrow-img-position w-full flex-1 bg-repeat-x arrow-img-position-2line  md:hidden" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/our-value-arrow.svg');"></div>
							</div>
						</span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="relative w-full block flex gap-[10px] title-our-values-2">
							<span class="font-light text-[#737373] pr-[5px] bg-white"><?= wp_kses_post($title_row_2) ?></span>
							<div class="arrow-img-position w-full flex-1 bg-repeat-x" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/our-value-arrow.svg');"></div>
						</span>
					<?php endif; ?>
				</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if($lists): ?>
			<div class="flex flex-wrap xl:gap-x-[60px] md:gap-y-[90px] lg:gap-x-[30px] gap-x-[20px] sm:gap-y-[40px] gap-y-[40px] px-4 md:px-10">
				<?php foreach($lists as $list): 
					$heading = $list['heading'];
					$content = $list['content'];
					?>
					<div class=" flex flex-row md:gap-[20px] gap-[16px] xl:w-[calc(33.33%-40px)] md:w-[calc(50%-15px)]">
						<div class="flex md:w-[50px] md:h-[50px] w-[48px] h-[48px] relative md:top-[-14px] top-[-8px]">
							<img src="<?php echo get_template_directory_uri() ?>/assets/imgs/list-icon.svg" alt="" class="w-full">
						</div>
						<div class="flex flex-col flex-1">
							<?php if($heading): ?>
								<h3 class="text-[clamp(20px,2.6vw,28px)] leading-[clamp(28px,3.2vw,36px)] tracking-[-2%] text-[#262626] font-heading font-bold md:mb-[18px] mb-[28px]"><?php echo $heading; ?></h3>
							<?php endif; ?>
							<?php if($content): ?>
								<div class="text-[18px] leading-[26px] text-[#525252] font-body tracking-[0px]"><?php echo $content; ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
      </div>
    </section>
<?php endwhile;
endif; ?>