<?php get_header() ?>
<main class="overflow-hidden">
    <?php the_content()?>

<?php if (have_posts()) : ?>
    <?php get_template_part('template-parts/blog/blog-hero'); ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
        <div class="wrapper">
            <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[20px]">
                <?php
                $post_index = 0;
                while (have_posts()) :
                    the_post();
                    $is_hidden = $post_index >= 6;
                    ?>
                    <article
                        id="post-<?php the_ID(); ?>"
                        data-initially-hidden="<?php echo $is_hidden ? '1' : '0'; ?>"
                        <?php post_class('bg-white rounded overflow-hidden view-more-item'); ?>
                        style="<?php echo $is_hidden ? 'display:none;' : ''; ?>"
                    >
                        <a href="<?php the_permalink(); ?>" class="block">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-[1/1] overflow-hidden">
                                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                                </div>
                            <?php endif; ?>
                        </a>

                        <div class="">
                            <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252]"><?php echo esc_html(get_the_date()); ?></p>
                            <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]">
                                <a href="<?php the_permalink(); ?>" class="hover:opacity-80 transition-opacity"><?php the_title(); ?></a>
                            </h2>

                            <div class="mt-[16px] view-more-btn">
                              <a class="inline-flex  gap-2 relative " href="<?php the_permalink(); ?>" target="_self">
                                  <span class="font-semibold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('READ MORE', 'mrl-site'); ?></span>
                                  <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg">
                              </a>
                          </div>
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
                        const step = 6;

                        if (!viewMoreButton) {
                            return;
                        }

                        const getHiddenItems = function () {
                            return Array.from(document.querySelectorAll('#blog-grid .view-more-item')).filter(function (item) {
                                return window.getComputedStyle(item).display === 'none';
                            });
                        };

                        const updateButtonState = function () {
                            const remainingHiddenItems = getHiddenItems();
                            if (remainingHiddenItems.length === 0) {
                                viewMoreButton.style.display = 'none';
                                viewMoreButton.setAttribute('aria-hidden', 'true');
                            } else {
                                viewMoreButton.style.display = '';
                                viewMoreButton.removeAttribute('aria-hidden');
                            }
                        };

                        updateButtonState();

                        viewMoreButton.addEventListener('click', function () {
                            const hiddenItems = getHiddenItems();
                            const nextItems = hiddenItems.slice(0, step);
                            nextItems.forEach(function (item) {
                                item.style.display = '';
                            });
                            updateButtonState();
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