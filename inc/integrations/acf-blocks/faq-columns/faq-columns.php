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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> faq-columns-sec bg-black px-4 md:px-10 pt-[60px] lg:pt-[80px] xl:pt-[120px] lg:pb-[100px] pb-[60px]">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<?php if($title_row_1 || $title_row_2 || $description): ?>
		<div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[50px] self-stretch w-full wrapper mb-[40px]">
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
		<div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col">
			
			<div class="faq-lists faq-lists-columns">
				<?php if ( ! empty( $faq_lists ) && is_array( $faq_lists ) ) : ?>
					<?php
						$half = (int) ceil( count( $faq_lists ) / 2 );
						$col1 = array_slice( $faq_lists, 0, $half );
						$col2 = array_slice( $faq_lists, $half );
					?>
					<div class="flex flex-col md:flex-row md:gap-[60px] faq-columns-wrapper md:first:border-t-0 first:border-t border-solid border-[#404040]">

						<?php foreach ( [ $col1, $col2 ] as $col_index => $column_faqs ) : ?>
						<div class="faq-column flex-1 flex flex-col">
							<?php $i = ( $col_index * $half ) + 1; ?>
							<?php foreach ( $column_faqs as $faq ) :
								$question = ! empty( $faq['question'] ) ? $faq['question'] : '';
								$answer   = ! empty( $faq['answer'] ) ? $faq['answer'] : '';
							?>
								<div class="flex flex-col bg-black text-white px-[6px] relative border-b border-[#404040] md:first:border-t border-solid">
									<h3 class="font-heading question font-medium text-white text-[clamp(16px,2.2vw,20px)] relative leading-[clamp(24px,2.6vw,28px)] xl:py-[32px] lg:py-[24px] py-[20px] pr-[50px] flex gap-[12px] items-start cursor-pointer ">
										<img src="<?= get_template_directory_uri() ?>/assets/imgs/faq-title-arrow.svg" alt="" class="faq-title-arrow w-[21px] h-[21px]"><?php echo $question; ?>
									</h3>
									<div class="answer md:pr-[50px] pr-[30px] pl-[34px]" role="region">
										<div class="font-body font-normal text-white text-[clamp(14px,1.7vw,16px)] leading-[clamp(22px,2.8vw,24px)] xl:pb-[32px] lg:pb-[24px] pb-[20px]">
											<?php echo wp_kses_post( $answer ); ?>
										</div>
									</div>
								</div>
							<?php $i++; endforeach; ?>
						</div>
						<?php endforeach; ?>

					</div>
				<?php endif; ?>
			</div>
			
		</div>
    </section>
<?php endwhile;
endif; ?>