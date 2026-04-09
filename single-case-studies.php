<?php
/**
 * Single Case Study template.
 *
 * Post type slug (from archive): case-studies
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[60px] lg:pb-[60px]">
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>

        <?php 
        $image = get_field('cs_logo');
        if( !empty( $image ) ): ?>
            <figure class="mb-[25px]"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="max-w-[150px] max-h-[150px] object-contain" /></figure>
        <?php endif; ?>

        <h1 class="font-heading max-w-[1054px] w-full font-bold text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626] mb-[17px]">
          <?php echo get_field('custom_single_page_title') ? : get_the_title(); ?>
        </h1>

        <?php
          $taxonomy = 'case-studies-categories';
          $terms    = get_the_terms(get_the_ID(), $taxonomy);
        ?>

        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
          <div class="flex flex-wrap gap-[8px] mb-[14px]">
            <?php foreach ($terms as $term) : ?>
              <span class="inline-flex items-center rounded-full border border-[#525252] px-[17px] py-[5px] text-[14px] leading-[20px] text-[#525252] shadow-[0px_1px_2px_0px_#0A0D120D]">
                <?php echo esc_html($term->name); ?>
              </span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="mt-[20px] overflow-hidden">
          <img src="https://wordpress-755960-6249701.cloudwaysapps.com/wp-content/themes/Mlrgroup/assets/imgs/single-blog-arrow-1.svg" alt="Blog Author" class="w-full">
        </div>

        <article class="max-w-[1360px] pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]">
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
