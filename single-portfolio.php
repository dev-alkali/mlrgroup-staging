<?php
/**
 * Single Portfolio Item template.
 *
 * Post type slug: portfolio
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[60px] lg:pb-[60px]">
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>

        <h1 class="font-heading font-bold max-w-[1125px] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em] text-[#262626] mb-[28px]">
          <?php the_title(); ?>
        </h1>

        <?php if (has_post_thumbnail()) : ?>
          <div class="overflow-hidden">
            <div class="aspect-[16/9]">
              <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
            </div>
          </div>
        <?php endif; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('pt-[60px] xl:px-[120px] lg:px-[60px] md:px-[30px] md:pb-[60px]'); ?>>
          <div class="blog-content">
            <?php the_content(); ?>
          </div>
        </article>

      <?php endwhile; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
