<?php get_header() ?>
<main class="overflow-hidden">
        <?php get_template_part('template-parts/blog/blog-hero'); ?>
        <?php the_content()?>

<?php if (have_posts()) : ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
        <div class="wrapper">
            <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[20px]">
                <?php
                $post_index = 0;
                while (have_posts()) :
                    the_post();
                    $is_hidden = $post_index >= 6;
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded overflow-hidden shadow-sm border border-[#E5E7EB]' . ($is_hidden ? ' hidden view-more-item' : ' view-more-item')); ?>>
                        <a href="<?php the_permalink(); ?>" class="block">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-[16/10] overflow-hidden">
                                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                                </div>
                            <?php endif; ?>
                        </a>

                        <div class="p-5">
                            <p class="text-sm text-[#6B7280] mb-2"><?php echo esc_html(get_the_date()); ?></p>
                            <h2 class="text-xl font-semibold leading-tight mb-4">
                                <a href="<?php the_permalink(); ?>" class="hover:opacity-80 transition-opacity"><?php the_title(); ?></a>
                            </h2>
                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium border border-[#111827] text-[#111827] hover:bg-[#111827] hover:text-white transition-colors">
                                <?php esc_html_e('READ MORE', 'mrl-site'); ?>
                            </a>
                        </div>
                    </article>
                    <?php
                    $post_index++;
                endwhile;
                ?>
            </div>

            <?php if ($post_index > 6) : ?>
                <div class="mt-10 text-center">
                    <button id="view-more-posts" type="button" class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold border border-[#111827] text-[#111827] hover:bg-[#111827] hover:text-white transition-colors">
                        <?php esc_html_e('VIEW MORE', 'mrl-site'); ?>
                    </button>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const viewMoreButton = document.getElementById('view-more-posts');
                        const hiddenItems = Array.from(document.querySelectorAll('#blog-grid .view-more-item.hidden'));
                        let currentIndex = 0;
                        const step = 6;

                        if (!viewMoreButton) {
                            return;
                        }

                        viewMoreButton.addEventListener('click', function () {
                            const nextItems = hiddenItems.slice(currentIndex, currentIndex + step);
                            nextItems.forEach(function (item) {
                                item.classList.remove('hidden');
                            });
                            currentIndex += step;

                            if (currentIndex >= hiddenItems.length) {
                                viewMoreButton.classList.add('hidden');
                            }
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </section>
<?php else : ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
        <div class="wrapper">
            <p><?php esc_html_e('No posts found.', 'mrl-site'); ?></p>
        </div>
    </section>
<?php endif; ?>
    <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer() ?>