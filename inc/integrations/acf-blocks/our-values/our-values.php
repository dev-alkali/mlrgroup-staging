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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> our-values-sec py-[60px] md:py-[120px] overflow-hidden <?php echo $bg_color_class; ?>">
      
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col">

	  <?php if($title_row_1 || $title_row_2 ): ?>
			<div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[50px] self-stretch w-full wrapper mb-[40px] px-4 md:px-10 overflow-visible">
				<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-[#262626] font-heading lg:mb-[20px]">
					<?php if($title_row_1): ?>
						<span class="font-bold "><?= wp_kses_post($title_row_1) ?></span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="font-light text-[#737373]"><?= wp_kses_post($title_row_2) ?></span>
					<?php endif; ?>
				</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if($lists): ?>
			<div class="flex flex-wrap md:gap-x-[60px] md:gap-y-[90px] gap-x-[30px] sm:gap-y-[40px] gap-y-[25px] px-4 md:px-10">
				<?php foreach($lists as $list): 
					$heading = $list['heading'];
					$content = $list['content'];
					?>
					<div class=" flex flex-row gap-[20px] md:w-[calc(33.33%-40px)]">
						<div class="flex w-[50px] h-[50px]">
							<img src="<?php echo get_template_directory_uri() ?>/assets/imgs/list-icon.svg" alt="" class="w-full">
						</div>
						<div class="flex flex-col flex-1">
							<?php if($heading): ?>
								<h3 class="text-[clamp(20px,2.6vw,28px)] leading-[clamp(28px,3.2vw,36px)] tracking-[-0.02em] text-[#262626] font-heading"><?php echo $heading; ?></h3>
							<?php endif; ?>
							<?php if($content): ?>
								<div class="text-[clamp(16px,1.8vw,18px)] leading-[clamp(24px,2.2vw,26px)] text-[#525252] font-body"><?php $content; ?></div>
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