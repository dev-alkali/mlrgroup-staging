<?php
/**
 * Single Blog Post template.
 */
get_header();
?>

<main class="overflow-hidden">
	<section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[60px] lg:pb-[60px]">
		<div class="wrapper">
			<?php while (have_posts()) : the_post(); ?>
				<div class="flex mb-[15px]">
					<p class="font-body font-normal text-[18px] md:text-[20px] md:leading-[28px] leading-[26px] tracking-[0] text-[#525252] post-date"><?php echo esc_html(get_the_date()); ?></p>
					<?php if (get_field('reading_time' , get_the_ID())) : ?>
						<p class="font-body font-normal text-[18px] md:text-[20px] md:leading-[28px] leading-[26px] tracking-[0] text-[#525252] post-reading-time relative pl-[16px] ml-[16px] before:content-[''] before:absolute before:top-1/2 before:left-0 before:block before:w-px before:h-[60%] before:bg-[#CCCCCC] before:-translate-y-1/2"><?php echo get_field('reading_time' , get_the_ID()); ?></p>
					<?php endif; ?>
				</div>
			
				<h1 class="font-heading font-bold w-full text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626]"><?php the_title(); ?></h1>

				<?php /*
				<div class="mt-[28px] overflow-hidden">
					<div class="aspect-[16/9]">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('full', ['class' => 'w-full h-full object-contain']); ?>
					<?php else : ?>
						<img class="w-full h-full object-contain" src="/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg" alt="">
					<?php endif; ?>
					</div>
				</div> */ ?>

				<div class="cs-arrow-row-post md:flex mt-[20px] hidden relative overflow-hidden items-center h-[50px]">
					<div class="absolute inset-0 flex flex-row-reverse items-center pr-[50px]">
						<?php for ($i = 0; $i < 40; $i++) : ?>
							<img src="<?= get_template_directory_uri() ?>/assets/imgs/cs_gray-arrow.svg" class="cs-gray-arrow-post w-[50px] h-[50px] shrink-0" alt="">
						<?php endfor; ?>
					</div>
					<div class="absolute right-0 z-10 bg-white">
						<img src="<?= get_template_directory_uri() ?>/assets/imgs/cs_red_arrow.svg" class="arrow1 w-[50px] h-[50px]" alt="">
					</div>
				</div>
				<script>
					(function () {
						function hideOverflowingArrowsPost() {
							var container = document.querySelector('.cs-arrow-row-post');
							if (!container) return;
							var containerLeft = container.getBoundingClientRect().left;
							var arrows = container.querySelectorAll('.cs-gray-arrow-post');
							arrows.forEach(function (arrow) {
								arrow.style.visibility = '';
								var arrowLeft = arrow.getBoundingClientRect().left;
								if (arrowLeft < containerLeft + 1) {
									arrow.style.visibility = 'hidden';
								}
							});
						}
						document.addEventListener('DOMContentLoaded', hideOverflowingArrowsPost);
						window.addEventListener('resize', hideOverflowingArrowsPost);
					})();
				</script>

				<article id="post-<?php the_ID(); ?>" <?php post_class('pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]'); ?> >
				
				<div class="blog-content max-w-[900px] ml-auto mr-auto">
					<?php the_content(); ?>
				</div>
				</article>
			<?php endwhile; ?>
		</div>
	</section>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>
