<?php get_header(); ?>
<main class="overflow-hidden">
  <?php get_template_part('template-parts/case-study/case-study-hero'); ?>

  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
          <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium'); ?>
            </a>
          </div>
        <?php endif; ?>

        <div class="entry-content">
          <?php the_excerpt(); ?>
        </div>
      </article>
    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>
  <?php else : ?>
    <p><?php esc_html_e('No case studies found.', 'score-site'); ?></p>
  <?php endif; ?>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>
<?php get_footer(); ?>
