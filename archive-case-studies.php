<?php
get_header();

$posts_per_page = 6;
$queried_object = get_queried_object();
$post_type      = '';

if ($queried_object instanceof WP_Post_Type && !empty($queried_object->name)) {
    $post_type = $queried_object->name;
} else {
    $post_type_query_var = get_query_var('post_type');
    if (is_array($post_type_query_var)) {
        $post_type = (string) reset($post_type_query_var);
    } elseif (is_string($post_type_query_var)) {
        $post_type = $post_type_query_var;
    }
}

if ($post_type === '') {
    $post_type = 'case-studies';
}

$post_type_obj  = get_post_type_object($post_type);
$rest_base      = !empty($post_type_obj->rest_base) ? $post_type_obj->rest_base : $post_type;

$case_studies_query = new WP_Query(
    [
        'post_type'           => $post_type,
        'post_status'         => 'publish',
        'posts_per_page'      => $posts_per_page,
        'ignore_sticky_posts' => true,
    ]
);

if (!$case_studies_query->have_posts() && have_posts()) {
    global $wp_query;
    $case_studies_query = $wp_query;
}
?>
<main class="overflow-hidden">
  <?php get_template_part('template-parts/case-study/case-study-hero'); ?>

  <section class="px-4 md:px-10 py-[60px] md:py-[120px]">
    <div class="wrapper">
      <?php if ($case_studies_query->have_posts()) : ?>
        <div id="case-studies-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-10">
          <?php while ($case_studies_query->have_posts()) : $case_studies_query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('overflow-hidden view-more-item'); ?>>
              <a href="<?php the_permalink(); ?>" class="block relative blog-card">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="aspect-[1/1] relative blog-card-img">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                  </div>
                <?php endif; ?>              
                <div>
                  <h2 class="font-[Poppins] font-bold text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] mt-[18px]"><?php echo esc_html(function_exists('get_field') && get_field('custom_single_page_title') ? get_field('custom_single_page_title') : get_the_title()); ?></h2>
                  <div class="mt-[16px] view-more-btn-p">
                    <div class="inline-flex gap-2 relative">
                      <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('VIEW CASE STUDY', 'mrl-site'); ?></span>
                      <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                    </div>
                  </div>
              </div>
              </a>
            </article>
          <?php endwhile; ?>
        </div>
      <?php else : ?>
        <div id="case-studies-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-10"></div>
      <?php endif; ?>

      <p id="case-studies-empty" class="mt-8 <?php echo $case_studies_query->have_posts() ? 'hidden' : ''; ?>">
        <?php esc_html_e('No case studies found.', 'score-site'); ?>
      </p>

        <?php if ($case_studies_query->max_num_pages > 1) : ?>
          <div
            id="case-studies-infinite-root"
            class="mt-[32px] md:mt-[60px] text-center view-more-btn"
            data-current-page="1"
            data-total-pages="<?php echo esc_attr($case_studies_query->max_num_pages); ?>"
          >
            <p id="case-studies-loading-more" class="hidden font-semibold text-accent text-[16px] leading-[24px] uppercase font-heading tracking-[0]" aria-live="polite"><?php esc_html_e('LOADING...', 'mrl-site'); ?></p>
            <div id="case-studies-infinite-scroll-sentinel" class="h-px w-full pointer-events-none" aria-hidden="true"></div>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const infiniteRoot = document.getElementById('case-studies-infinite-root');
              const loadingEl = document.getElementById('case-studies-loading-more');
              const sentinel = document.getElementById('case-studies-infinite-scroll-sentinel');
              const grid = document.getElementById('case-studies-grid');
              const emptyState = document.getElementById('case-studies-empty');
              const viewCaseStudyText = '<?php echo esc_js(__('VIEW CASE STUDY', 'mrl-site')); ?>';

              if (!grid || !infiniteRoot || !sentinel || typeof IntersectionObserver === 'undefined') {
                return;
              }

              let totalPages = parseInt(infiniteRoot.getAttribute('data-total-pages'), 10);
              let currentPage = parseInt(infiniteRoot.getAttribute('data-current-page'), 10);
              let isLoading = false;
              /* let selectedTerm = filterSelect ? parseInt(filterSelect.value, 10) : 0; */
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
                      fetchPostsPage(currentPage + 1, true);
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

              const createCard = function (post) {
                const article = document.createElement('article');
                article.id = 'post-' + post.id;
                article.className = 'post type-' + '<?php echo esc_js($post_type); ?>' + ' status-publish overflow-hidden view-more-item';

                const title = post.acf_display_title || (post.title && post.title.rendered ? post.title.rendered : '');
                const featuredImageUrl = getFeaturedImageUrl(post);
                let termsMarkup = '';

                article.innerHTML = `
                  <a href="${post.link}" class="block relative blog-card">
                    ${featuredImageUrl ? `
                      <div class="aspect-[1/1] relative blog-card-img">
                        <img class="w-full h-full object-cover" src="${featuredImageUrl}" alt="${title}" loading="lazy">
                      </div>
                    ` : ''}
                  
                    <div>
                      <h2 class="font-[Poppins] font-bold text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] mt-[18px]">${title}</h2>
                      ${termsMarkup ? `<div class="mt-[10px] flex flex-wrap gap-[8px]">${termsMarkup}</div>` : ''}
                      <div class="mt-[16px] view-more-btn-p">
                        <div class="inline-flex gap-2 relative">
                          <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]">${viewCaseStudyText}</span>
                          <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                        </div>
                      </div>
                    </div>
                  </a>
                `;

                grid.appendChild(article);
              };

              const fetchPostsPage = function (page, shouldAppend) {
                if (isLoading || currentPage >= totalPages) {
                  return Promise.resolve();
                }

                isLoading = true;
                setLoadingVisible(true);

                const endpoint = new URL(`${window.location.origin}/wp-json/wp/v2/<?php echo esc_js($rest_base); ?>`);
                endpoint.searchParams.set('per_page', '<?php echo esc_js($posts_per_page); ?>');
                endpoint.searchParams.set('page', String(page));
                endpoint.searchParams.set('_embed', '1');
                

                return fetch(endpoint.toString(), {
                  headers: { 'Accept': 'application/json' }
                })
                .then(function (response) {
                  if (!response.ok) {
                    throw new Error('Failed to fetch case studies');
                  }
                  const totalPagesHeader = parseInt(response.headers.get('X-WP-TotalPages') || '1', 10);
                  totalPages = isNaN(totalPagesHeader) ? 1 : totalPagesHeader;
                  return response.json();
                })
                .then(function (posts) {
                  if (!shouldAppend) {
                    grid.innerHTML = '';
                  }
                  posts.forEach(createCard);
                  currentPage = page;
                  infiniteRoot.setAttribute('data-current-page', String(currentPage));
                  infiniteRoot.setAttribute('data-total-pages', String(totalPages));
                  if (emptyState) {
                    if (grid.children.length === 0) {
                      emptyState.classList.remove('hidden');
                    } else {
                      emptyState.classList.add('hidden');
                    }
                  }
                  if (currentPage >= totalPages) {
                    disconnectInfiniteScroll();
                  } else {
                    connectInfiniteScroll();
                  }
                })
                .catch(function (error) {
                  if (window.console && console.error) {
                    console.error('Case studies infinite load failed:', error);
                  }
                })
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
  <?php wp_reset_postdata(); ?>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>
<?php get_footer(); ?>
