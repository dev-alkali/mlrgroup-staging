<?php
/**
 * Single Case Study template.
 *
 * Post type slug (from archive): case-studies
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[40px] lg:pb-[60px]">
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>

        <?php 
        $image = get_field('cs_logo');
        if( !empty( $image ) ): ?>
            <figure class="mb-[25px]"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></figure>
        <?php endif; ?>

        <h1 class="font-heading max-w-[1054px] w-full font-bold text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626] mb-[17px]">
          <?php the_title(); ?>
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

        <?php if (has_post_thumbnail()) : ?>
          <div class="mt-[20px] overflow-hidden">
            <div class="aspect-[17/10] bg-[#F5F5F5]">
              <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
            </div>
          </div>
        <?php endif; ?>

        <article class="md:pt-[120px] pt-[60px] md:px-[120px] md:pb-[60px]">
          <div class="mb-[20px]">
            <h2 class="font-heading font-bold text-[clamp(28px,4vw,40px)] leading-[clamp(36px,4.5vw,48px)] tracking-[-2%] text-[#262626]">Summary:</h2>
          </div>
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
