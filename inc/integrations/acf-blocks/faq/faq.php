<?php

/**
 * faq Block Template.
 */

$id = 'faq' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'faq';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('faq')) :  while (have_rows('faq')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');
$left_image_or_right_image = get_sub_field('left_image_or_right_image');
$layout = get_sub_field('left_image_or_right_image'); // left / right
// Desktop layout
$desktopFlex = ($layout === 'Right Image') ? 'md:flex-row-reverse' : 'md:flex-row';

$faq_lists = get_sub_field('faq_lists');

// Mobile: always content first, image bottom
$mobileFlex = 'flex-col-reverse';

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] md:py-[120px]">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<div class="flex flex-col lg:flex-row lg:items-center gap-[20px] lg:gap-[50px] self-stretch w-full">
			<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-[#262626] font-heading mb-[20px]">
					<?php if($title_row_1): ?>
						<span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="font-light text-[#737373]"><?= wp_kses_post($title_row_2) ?></span>
					<?php endif; ?>
				</h2>
			<?php endif; ?>
			<?php if($description): ?>
				<div class="flex flex-col items-start gap-8 flex-1 serve-content ">
					<p class="max-w-[526px] font-body font-normal text-[#525252] text-[clamp(18px,2.2vw,20px)] leading-[clamp(26px,2.6vw,28px)]"><?php echo $description; ?></p>
				</div>
			<?php endif; ?>
		</div>
		<div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col <?php echo $mobileFlex . ' ' . $desktopFlex; ?> items-center">

			<div class="w-full flex-1">
			<figure><?php echo wp_get_attachment_image(get_sub_field('image'), 'full', false, ['class' => 'w-full h-auto']); ?></figure>
			</div>

			<div class="w-full flex-1">
				<div class="">
					<?php if($faq_lists): ?>
						<div class="flex flex-col gap-[20px]">
							<?php 
							 $i = 1;
							foreach($faq_lists as $faq): ?>
								<div class="flex flex-col bg-black text-white px-[28px] py-[36px] relative">
									<h3 class="font-heading question font-medium text-white text-[clamp(18px,2.2vw,20px)] relative leading-[clamp(26px,2.6vw,28px)] pr-[50px]"><?php echo $i; ?> <?php echo $faq['question']; ?></h3>
									<div class="answer pr-[50px]">
										<div class="font-body font-normal text-white text-[clamp(14px,1.7vw,16px)] leading-[clamp(24px,2.8vw,26px)] "><?php echo $faq['answer']; ?></div>
									</div>
								</div>
							<?php $i++; endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
    </section>
<?php endwhile;
endif; ?>