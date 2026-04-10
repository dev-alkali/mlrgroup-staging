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
			
				<h1 class="font-heading font-bold max-w-[1125px] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626]"><?php the_title(); ?></h1>

				<div class="mt-[28px] overflow-hidden">
					<div class="aspect-[16/9]">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('full', ['class' => 'w-full h-full object-contain']); ?>
					<?php else : ?>
						<img class="w-full h-full object-contain" src="/wp-content/themes/Mlrgroup/assets/imgs/altr-img.jpg" alt="">
					<?php endif; ?>
					</div>
				</div>

				<div class="md:flex mt-[20px] hidden">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/single-blog-arrow-1.svg" alt="Blog Author" class="w-full">
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class('pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]'); ?> >
				
				<div class="blog-content">
					<?php the_content(); ?>
				</div>
				</article>
			<?php endwhile; ?>
		</div>
	</section>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>
