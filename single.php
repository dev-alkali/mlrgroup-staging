<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <div class="entry-meta">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"> <?php esc_html_e('by', 'score-site'); ?> <?php the_author(); ?></span>
                    <div class="rt_reading_time"><?php echo do_shortcode('[rt_reading_time]');?></div>
                    <div class="rt_reading_time"><?php echo do_shortcode('[rt_reading_time label="Reading Time:" postfix="minutes" postfix_singular="minute"]');?></div>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'score-site'),
                    'after' => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                $categories_list = get_the_category_list(', ');
                if ($categories_list) {
                    printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'score-site') . '</span>', $categories_list);
                }

                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) {
                    printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'score-site') . '</span>', $tags_list);
                }
                ?>
            </footer>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
    endwhile;
    ?>

</main>

<?php
//get_sidebar();
get_footer();
