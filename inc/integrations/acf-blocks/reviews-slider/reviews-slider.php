<?php

/**
 * Reviews Slider Block Template.
 */

$id = 'reviews-slider' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'reviews-slider';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('reviews-slider')) :  while (have_rows('reviews-slider')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$review_sliders = get_sub_field('review_sliders');

//$left_image_or_right_image = get_sub_field('left_image_or_right_image');

// Desktop layout


// Mobile: always content first, image bottom
$mobileFlex = 'flex-col-reverse';

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] md:py-[120px]">
		<div class="gap-[30px] md:gap-[60px] w-full wrapper ">

			<div class="w-full ">
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
			</div>

			<div class="w-full">
				<div class="reviews-slider">
					<?php foreach($review_sliders as $review_slider): 
						$review_image = $review_slider['review_image'];
						$review_content = $review_slider['review_content'];
						$review_company_logo = $review_slider['review_company_logo'];
						$review_author_name = $review_slider['review_author_name'];
						$review_author_role = $review_slider['review_author_role'];
						?>
						<div class="review-slider-item lg:w-[1206px] md:w-[738px] sm:w-[500px] w-[360px]">
							<div class="flex flex-col md:flex-row flex-wrap p-[20px] md:p-[30px] lg:p-[40px] bg-black text-white gap-[32px]">
								<div class="w-full md:w-1/2 flex items-center justify-center">
									<div class="w-full h-full">
										<img src="<?php echo $review_image['url']; ?>" alt="<?php echo $review_image['alt']; ?>">
									</div>
								</div>
								<div class="w-full md:w-1/2">
									<div class="text-[clamp(16px,2.2vw,24px)] leading-[clamp(24px,2.8vw,32px)] tracking-[clamp(0em,-0.2vw,-0.02em)] mb-[20px]"><?php echo $review_content; ?></div>
									<div class="flex items-center gap-[16px]">
										<img src="<?php echo $review_company_logo['url']; ?>" alt="<?php echo $review_company_logo['alt']; ?>" class="w-[60px] h-[60px] object-contain">
										<div class="flex flex-col flex-1">
											<div class="text-[16px] leading-[18px] font-bold text-white"><?php echo $review_author_name; ?></div>
											<div class="text-[14px] leading-[16px] font-normal text-white"><?php echo $review_author_role; ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
    </section>
<?php endwhile;
endif; ?>