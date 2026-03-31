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
					<p class="font-body font-normal text-[18px] md:text-[20px] md:leading-[28px] leading-[26px] tracking-[0] text-[#525252] post-reading-time relative pl-[16px] ml-[16px] before:content-[''] before:absolute before:top-1/2 before:left-0 before:block before:w-px before:h-[60%] before:bg-[#CCCCCC] before:-translate-y-1/2"><?php echo get_field('reading_time' , get_the_ID()); ?></p>
				</div>
			


				<h1 class="font-heading font-bold max-w-[1125px] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626]">
				<?php the_title(); ?>
				</h1>

				<?php if (has_post_thumbnail()) : ?>
				<div class="mt-[28px] overflow-hidden">
					<div class="aspect-[16/9] bg-[#F5F5F5]">
					<?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
					</div>
				</div>
				<?php endif; ?>

				<div class="md:flex mt-[20px] hidden">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/single-blog-arrow-1.svg" alt="Blog Author" class="w-full">
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class('pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]'); ?> >
				<div class="">
					<h2 class="font-heading font-bold text-[clamp(28px,4vw,40px)] leading-[clamp(36px,4.5vw,48px)] tracking-[-2%] text-[#262626] mb-[20px]">Summary:</h2>       
				</div>
				<div class="blog-content">
					<?php the_content(); ?>
				</div>

				<?php /*
					$categories = get_the_category();
					$tags       = get_the_tags();
				?>

				<?php if (!empty($categories)) : ?>
					<div class="mt-[28px]">
						<p class="font-heading font-semibold text-[#262626] mb-[10px]"><?php esc_html_e('Categories', 'mrl-site'); ?></p>
						<div class="flex flex-wrap gap-[8px]">
							<?php foreach ($categories as $cat) : ?>
							<a
								href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
								class="inline-flex items-center rounded-full border border-[#525252] px-[17px] py-[5px] text-[14px] leading-[20px] text-[#525252] hover:opacity-80 transition-opacity"
							>
								<?php echo esc_html($cat->name); ?>
							</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if (!empty($tags) && !is_wp_error($tags)) : ?>
					<div class="mt-[20px]">
						<p class="font-heading font-semibold text-[#262626] mb-[10px]"><?php esc_html_e('Tags', 'mrl-site'); ?></p>
						<div class="flex flex-wrap gap-[8px]">
							<?php foreach ($tags as $tag) : ?>
							<a
								href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
								class="inline-flex items-center rounded-full border border-[#CFCFCF] px-[17px] py-[5px] text-[14px] leading-[20px] text-[#525252] hover:opacity-80 transition-opacity"
							>
								<?php echo esc_html($tag->name); ?>
							</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; */ ?>
				</article>
			<?php endwhile; ?>
		</div>
	</section>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>
