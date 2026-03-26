<?php

/**
 * faq Block Template.
 */

$id = 'faq-columns' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'faq-columns';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('faq-columns')) :  while (have_rows('faq-columns')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$faq_lists = get_sub_field('faq_lists');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> faq-columns-sec bg-black bpx-4 md:px-10 pt-[60px] lg:pt-[80px] xl:pt-[120px] lg:pb-[100px] pb-[60px]">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<?php if($title_row_1 || $title_row_2 || $description): ?>
		<div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[50px] self-stretch w-full wrapper lg:mb-[60px] mb-[40px]">
			<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-white font-heading lg:mb-[20px]">
					<?php if($title_row_1): ?>
						<span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
					<?php endif; ?>
				</h2>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col ">
			<div class="w-full flex-1">
				<div class="">
					<?php if($faq_lists): ?>
						<?php if ( ! empty( $faq_lists ) && is_array( $faq_lists ) ) : ?>
							<div class="flex flex-col md:gap-[16px] gap-[10px]">
								<?php $i = 1; ?>
								<?php foreach ( $faq_lists as $faq ) : 
									$question = ! empty( $faq['question'] ) ? $faq['question'] : '';
									$answer   = ! empty( $faq['answer'] ) ? $faq['answer'] : '';
								?>
									<div class="flex flex-col bg-black text-white md:px-[28px] px-[20px] md:py-[36px] py-[20px] relative">
										<h3 class="font-heading question font-medium text-white text-[clamp(16px,2.2vw,20px)] relative leading-[clamp(24px,2.6vw,28px)] pr-[50px]">
											<?php echo $i . '. ' . esc_html( $question ); ?>
										</h3>
										<div class="answer md:pr-[50px] pr-[30px]" role="region">
											<div class="font-body font-normal text-white text-[clamp(14px,1.7vw,16px)] leading-[clamp(22px,2.8vw,24px)] mt-[10px]">
												<?php echo wp_kses_post( $answer ); ?>
											</div>
										</div>
									</div>
								<?php $i++; endforeach; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
    </section>
<?php endwhile;
endif; ?>