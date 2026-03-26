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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> our-values-sec  px-4 md:px-10 py-[60px] md:py-[120px] <?php echo $bg_color_class; ?>">
      
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col">

		<?php if($title_row_1 || $title_row_2 ): ?>
			<div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[50px] self-stretch w-full wrapper mb-[40px]">
				<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-[#262626] font-heading lg:mb-[20px]">
					<?php if($title_row_1): ?>
						<span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="font-light text-[#737373]"><?= wp_kses_post($title_row_2) ?></span>
					<?php endif; ?>
				</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if($lists): ?>
			<div class="flex flex-col md:gap-[16px] gap-[10px]">
				<?php foreach($lists as $list): 
					$heading = $list['heading'];
					$content = $list['content'];
					?>
					<div class=" flex flex-row gap-[20px]">
						<div class="flex">
							<img src="<?php get_template_directory_uri() ?>/assets/imgs/list-icon.svg" alt="" class="w-[50px] h-[50px]">
						</div>
						<div class="flex flex-col">
							<?php if($heading): ?>
								<h3 class="text-[clamp(20px,2.6vw,28px)] leading-[clamp(28px,3.2vw,36px)] tracking-[-0.02em] text-[#262626] font-heading"><?= wp_kses_post($list['title']) ?></h3>
							<?php endif; ?>
							<?php if($content): ?>
								<div class="text-[clamp(16px,1.8vw,18px)] leading-[clamp(24px,2.2vw,26px)] text-[#525252] font-body"><?= wp_kses_post($list['content']) ?></div>
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