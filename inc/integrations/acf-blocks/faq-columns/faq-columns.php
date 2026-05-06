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
$select_background_color = get_sub_field('select_background_color');

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

$section_bg_class   = 'bg-black';
$section_text_class = 'text-white';
$border_color_class = 'border-[#404040]';

if ( 'White' === $select_background_color ) {
	$section_bg_class   = 'bg-white';
	$section_text_class = 'text-black';
	$border_color_class = 'border-[#d9d9d9]';
}

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> faq-columns-sec <?php echo esc_attr($section_bg_class); ?> px-4 md:px-10 pt-[60px] lg:pt-[80px] lg:pb-[80px] pb-[60px]<?php echo $pt_class; ?><?php echo $pb_class; ?>">
		<!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
		<?php if($title_row_1 || $title_row_2 || $description): ?>
		<div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[40px] self-stretch w-full wrapper mb-[0px]">
			<?php if($title_row_1 || $title_row_2): ?>
				<h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] <?php echo esc_attr($section_text_class); ?> font-heading lg:mb-[20px]">
					<?php if($title_row_1): ?>
						<span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
					<?php endif; ?>
					<?php if($title_row_2): ?>
						<span class="font-bold"><?= wp_kses_post($title_row_2) ?></span>
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
					<div class="flex flex-col md:flex-row md:gap-[60px] faq-columns-wrapper md:first:border-t-0 first:border-t border-solid <?php echo esc_attr($border_color_class); ?>">

						<?php foreach ( [ $col1, $col2 ] as $col_index => $column_faqs ) : ?>
						<div class="faq-column flex-1 flex flex-col">
							<?php $i = ( $col_index * $half ) + 1; ?>
							<?php foreach ( $column_faqs as $faq ) :
								$question = ! empty( $faq['question'] ) ? $faq['question'] : '';
								$answer   = ! empty( $faq['answer'] ) ? $faq['answer'] : '';
							?>
								<div class="flex flex-col <?php echo esc_attr($section_bg_class); ?> <?php echo esc_attr($section_text_class); ?> px-[6px] relative border-b <?php echo esc_attr($border_color_class); ?> md:first:border-t border-solid">
									<h3 class="font-heading question font-medium <?php echo esc_attr($section_text_class); ?> text-[clamp(16px,2.2vw,20px)] relative leading-[clamp(24px,2.6vw,28px)] xl:py-[24px] lg:py-[24px] py-[20px] pr-[50px] flex gap-[12px] items-start cursor-pointer ">
										<?php echo $question; ?>
									</h3>
									<div class="answer md:pr-[50px] pr-[30px]" role="region">
										<div class="font-body font-normal <?php echo esc_attr($section_text_class); ?> text-[clamp(14px,1.7vw,16px)] leading-[clamp(22px,2.8vw,24px)] xl:pb-[24px] lg:pb-[24px] pb-[20px]">
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