<?php
get_header();

$posts_per_page = 6;
$initial_posts_query = new WP_Query(
    [
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $posts_per_page,
        'ignore_sticky_posts' => true,
    ]
);
?>
<main class="overflow-hidden">
    <?php //the_content(); ?>

<?php if ($initial_posts_query->have_posts()) : ?>
    <?php get_template_part('template-parts/blog/blog-hero'); ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[60px]">
        <div class="wrapper">
            <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-10">
                <?php
                while ($initial_posts_query->have_posts()) :
                    $initial_posts_query->the_post();
                    ?>
                    <article
                        id="post-<?php the_ID(); ?>"
                        <?php post_class('overflow-hidden view-more-item '); ?>
                    >
                        <a href="<?php the_permalink(); ?>" class="block relative blog-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-[1/1] relative  blog-card-img">
                                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                                </div>
                            <?php endif; ?>                        
                        <div class="">
                            <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252] mt-[16px] mb-[6px]"><?php echo esc_html(get_the_date()); ?></p>
                            <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]"><?php the_title(); ?></h2>

                            <div class="mt-[16px] view-more-btn-p">
                              <div class="inline-flex  gap-2 relative">
                                  <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('READ MORE', 'mrl-site'); ?></span>
                                  <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg">
                              </div>
                          </div>
                        </div>
                        </a>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php if ($initial_posts_query->max_num_pages > 1) : ?>
                <div
                    id="blog-infinite-root"
                    class="mt-[32px] md:mt-[60px] text-center view-more-btn"
                    data-current-page="1"
                    data-total-pages="<?php echo esc_attr($initial_posts_query->max_num_pages); ?>"
                >
                    <p id="blog-loading-more" class="hidden font-semibold text-accent text-[16px] leading-[24px] uppercase font-heading tracking-[0]" aria-live="polite"><?php esc_html_e('LOADING...', 'mrl-site'); ?></p>
                    <div id="blog-infinite-scroll-sentinel" class="h-px w-full pointer-events-none" aria-hidden="true"></div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const root = document.getElementById('blog-infinite-root');
                        const blogGrid = document.getElementById('blog-grid');
                        const loadingEl = document.getElementById('blog-loading-more');
                        const sentinel = document.getElementById('blog-infinite-scroll-sentinel');

                        if (!root || !blogGrid || !sentinel || typeof IntersectionObserver === 'undefined') {
                            return;
                        }

                        let totalPages = parseInt(root.getAttribute('data-total-pages'), 10);
                        let currentPage = parseInt(root.getAttribute('data-current-page'), 10);
                        let isLoading = false;
                        let scrollObserver = null;

                        const setLoadingVisible = function (visible) {
                            if (loadingEl) {
                                loadingEl.classList.toggle('hidden', !visible);
                            }
                        };

                        const disconnectInfiniteScroll = function () {
                            if (scrollObserver) {
                                scrollObserver.disconnect();
                                scrollObserver = null;
                            }
                        };

                        const connectInfiniteScroll = function () {
                            disconnectInfiniteScroll();
                            if (currentPage >= totalPages) {
                                return;
                            }
                            scrollObserver = new IntersectionObserver(
                                function (entries) {
                                    entries.forEach(function (entry) {
                                        if (!entry.isIntersecting || isLoading || currentPage >= totalPages) {
                                            return;
                                        }
                                        loadNextPage();
                                    });
                                },
                                { rootMargin: '240px 0px 0px 0px', threshold: 0 }
                            );
                            scrollObserver.observe(sentinel);
                        };

                        const getFeaturedImageUrl = function (post) {
                            if (!post._embedded || !post._embedded['wp:featuredmedia'] || !post._embedded['wp:featuredmedia'][0]) {
                                return '';
                            }

                            const media = post._embedded['wp:featuredmedia'][0];
                            if (media.media_details && media.media_details.sizes) {
                                const sizes = media.media_details.sizes;
                                if (sizes.large && sizes.large.source_url) {
                                    return sizes.large.source_url;
                                }
                                if (sizes.medium_large && sizes.medium_large.source_url) {
                                    return sizes.medium_large.source_url;
                                }
                                if (sizes.full && sizes.full.source_url) {
                                    return sizes.full.source_url;
                                }
                            }

                            return media.source_url || '';
                        };

                        const createPostCard = function (post) {
                            const article = document.createElement('article');
                            article.id = 'post-' + post.id;
                            article.className = 'post type-post status-publish format-standard hentry overflow-hidden view-more-item';

                            const featuredImageUrl = getFeaturedImageUrl(post);
                            const postDate = new Date(post.date);
                            const formattedDate = isNaN(postDate.getTime())
                                ? ''
                                : postDate.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });

                            article.innerHTML = `
                                <a href="${post.link}" class="block relative blog-card">
                                    ${featuredImageUrl ? `
                                        <div class="aspect-[1/1] relative  blog-card-img">
                                            <img class="w-full h-full object-cover" src="${featuredImageUrl}" alt="${post.title.rendered}" loading="lazy">
                                        </div>
                                    ` : ''}
                                
                                <div class="">
                                    <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252] mt-[16px] mb-[6px]">${formattedDate}</p>
                                    <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]">${post.title.rendered}</h2>
                                    <div class="mt-[16px] view-more-btn-p">
                                        <div class="inline-flex gap-2 relative">
                                            <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php echo esc_js(__('READ MORE', 'mrl-site')); ?></span>
                                            <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                </a>
                            `;

                            blogGrid.appendChild(article);
                        };

                        const loadNextPage = function () {
                            if (isLoading || currentPage >= totalPages) {
                                return;
                            }

                            isLoading = true;
                            setLoadingVisible(true);

                            const nextPage = currentPage + 1;
                            const endpoint = `${window.location.origin}/wp-json/wp/v2/posts?per_page=<?php echo esc_js($posts_per_page); ?>&page=${nextPage}&_embed`;

                            fetch(endpoint, {
                                headers: { 'X-WP-Nonce': '<?php echo esc_js(wp_create_nonce('wp_rest')); ?>' }
                            })
                                .then(function (response) {
                                    if (!response.ok) {
                                        throw new Error('Failed to fetch posts');
                                    }
                                    return response.json();
                                })
                                .then(function (posts) {
                                    posts.forEach(createPostCard);
                                    currentPage = nextPage;
                                    root.setAttribute('data-current-page', String(currentPage));
                                    if (currentPage >= totalPages) {
                                        disconnectInfiniteScroll();
                                    } else {
                                        connectInfiniteScroll();
                                    }
                                })
                                .catch(function () {})
                                .finally(function () {
                                    isLoading = false;
                                    setLoadingVisible(false);
                                });
                        };

                        connectInfiniteScroll();
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
<?php wp_reset_postdata(); ?>
    <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>