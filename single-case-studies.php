<?php
/**
 * Single Case Study template.
 *
 * Post type slug (from archive): case-studies
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="px-4 md:px-10 pt-[140px] md:pt-[180px] pb-[40px] lg:pb-[60px]">
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>
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

        <h1 class="font-heading font-bold text-[clamp(34px,5vw,56px)] leading-[1.1] tracking-[-0.02em] text-[#262626]">
          <?php the_title(); ?>
        </h1>

        <?php if (has_post_thumbnail()) : ?>
          <div class="mt-[28px] overflow-hidden">
            <div class="aspect-[16/9] bg-[#F5F5F5]">
              <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
            </div>
          </div>
        <?php endif; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('mt-[28px]'); ?>>
          <div class="prose prose-lg max-w-none prose-headings:font-heading prose-p:font-body">
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>
