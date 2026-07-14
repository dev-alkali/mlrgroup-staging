<?php
/**
 * Single Case Study template.
 *
 * Post type slug (from archive): case-studies
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="pt-[40px] pb-0 bg-white main-div-sec border-t border-[#000]">
    <div class="px-4 md:px-10">

    
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>

        <?php 
        $image = get_field('cs_logo');
        $custom_summary_content = get_field('custom_summary_content');
        if( !empty( $image ) ): ?>
            <figure class="mb-[25px]"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="max-w-[120px] max-h-[80px] object-contain" /></figure>
        <?php endif; ?>

        <p class="overview-link font-heading uppercase font-bold flex items-center gap-[6px] text-[20px] lg:mt-[70px] mt-[50px] lg:mb-[20px] mb-[15px] tracking-[0.3px]">
          <span>Overview</span>
          <img class="w-4 h-4 -mt-[3px]" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue.svg" alt="">
        </p>

        <h1 class="font-heading w-full font-bold text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626] mb-[17px]">
          <?php echo get_field('custom_single_page_title') ? : get_the_title(); ?>
        </h1>

        <?php if( !empty( $custom_summary_content ) ): ?>
          <div class="custom-summary-content mb-[30px] max-w-[1294px]">
            <?php echo $custom_summary_content; ?>
          </div>
        <?php endif; ?>

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
      <?php endwhile; ?>
    </div>
    </div>
    <article class="case-studies-content pt-[60px]">
          <div class="blog-content">  
            <?php the_content(); ?>
          </div>
        </article>
  </section>
</main>

<?php get_footer(); ?>
