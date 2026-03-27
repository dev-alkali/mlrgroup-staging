<?php get_header() ?>
<main class="overflow-hidden">
        <?php get_template_part('template-parts/blog/blog-hero'); ?>
        <?php the_content()?>

        <?php if (have_posts()) : ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
        <div class="wrapper">
        <?php
        // Start the Loop
        while (have_posts()) :
            the_post();
            ?>

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

                <footer class="entry-footer">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"> <?php esc_html_e('by', 'mrl-site'); ?> <?php the_author(); ?></span>
                </footer>
            </article>

        <?php
        endwhile;

        // Pagination
        the_posts_pagination();

        else : ?>
        <p><?php esc_html_e('No posts found.', 'score-site'); ?></p>
        </div>
    </section>


    <?php endif; ?>
    <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer() ?>