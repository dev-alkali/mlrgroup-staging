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

        <h1 class="font-heading w-full font-bold text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626] mb-[17px]">
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

        <div class="md:flex mt-[20px] hidden">
          <div class="w-full flex justify-end bg-[length:30px] md:bg-[length:50px] bg-repeat-x bg-[position:right_30px_center] md:bg-[position:right_49px_center]" style="background-image:url(<?= get_template_directory_uri() ?>/assets/imgs/cs_gray-arrow.svg);"><img src="<?= get_template_directory_uri() ?>/assets/imgs/cs_red_arrow.svg" class="arrow1 w-[clamp(30px,7vw,50px)] h-[clamp(30px,7vw,50px)] bg-white" alt=""></div>
        </div>

        <article class="max-w-[1360px] mx-auto pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]">
          <div class="blog-content">  
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>

  <?php // get_template_part('template-parts/cta/cta'); ?>

  <?php get_template_part('template-parts/ctas-mulitple/ctas-mulitple'); ?>

</main>

<?php get_footer(); ?>
