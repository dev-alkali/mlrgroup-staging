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
$filter_taxonomy = 'case-studies-categories';
$taxonomy_rest_base = '';
$selected_term = isset($_GET['cs_category']) ? absint($_GET['cs_category']) : 0;

if ($filter_taxonomy !== '') {
    $taxonomy_obj = get_taxonomy($filter_taxonomy);
    if ($taxonomy_obj && !empty($taxonomy_obj->rest_base)) {
        $taxonomy_rest_base = $taxonomy_obj->rest_base;
    } else {
        $taxonomy_rest_base = $filter_taxonomy;
    }
}

$case_studies_query = new WP_Query(
    [
        'post_type'           => $post_type,
        'post_status'         => 'publish',
        'posts_per_page'      => $posts_per_page,
        'ignore_sticky_posts' => true,
        'tax_query'           => ($filter_taxonomy !== '' && $selected_term > 0)
            ? [
                [
                    'taxonomy' => $filter_taxonomy,
                    'field'    => 'term_id',
                    'terms'    => [$selected_term],
                ],
            ]
            : [],
    ]
);

if (!$case_studies_query->have_posts() && have_posts()) {
    global $wp_query;
    $case_studies_query = $wp_query;
}
?>
<main class="overflow-hidden">
  <?php get_template_part('template-parts/case-study/case-study-hero'); ?>

  <section class="px-4 md:px-10 py-[40px] lg:py-[80px] xl:py-[60px]">
    <div class="wrapper">
      <?php if ($filter_taxonomy !== '') : ?>
        <?php
        $filter_terms = get_terms(
            [
                'taxonomy'   => $filter_taxonomy,
                'hide_empty' => true,
            ]
        );
        ?>
        <div class="mb-8 md:mb-10">
          <label for="case-studies-filter" class="mr-2 text-[#525252] font-body text-[16px] leading-[24px]"><?php esc_html_e('Filter by', 'mrl-site'); ?></label>
          <select
            id="case-studies-filter"
            class="border border-[#D9D9D9] rounded-[4px] px-3 py-2 min-w-[180px] text-[16px] leading-[24px]"
            data-taxonomy="<?php echo esc_attr($filter_taxonomy); ?>"
            data-taxonomy-rest-base="<?php echo esc_attr($taxonomy_rest_base); ?>"
            data-selected-term="<?php echo esc_attr($selected_term); ?>"
          >
            <option value="0"><?php esc_html_e('All', 'mrl-site'); ?></option>
            <?php if (!is_wp_error($filter_terms)) : ?>
              <?php foreach ($filter_terms as $term) : ?>
                <option value="<?php echo esc_attr($term->term_id); ?>" <?php selected($selected_term, (int) $term->term_id); ?>>
                  <?php echo esc_html($term->name); ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      <?php endif; ?>

      <?php if ($case_studies_query->have_posts()) : ?>
        <div id="case-studies-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-10">
          <?php while ($case_studies_query->have_posts()) : $case_studies_query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('overflow-hidden view-more-item'); ?>>
              <a href="<?php the_permalink(); ?>" class="block relative blog-card">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="aspect-[1/1]">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                  </div>
                <?php endif; ?>
              </a>

              <div>
                <h2 class="font-[Poppins] font-bold text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626]">
                  <a href="<?php the_permalink(); ?>" class="hover:opacity-80 transition-opacity"><?php the_title(); ?></a>
                </h2>

                <?php if ($filter_taxonomy !== '') : ?>
                  <?php $terms = get_the_terms(get_the_ID(), $filter_taxonomy); ?>
                  <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                    <div class="mt-[14px] flex flex-wrap gap-[8px]">
                      <?php foreach ($terms as $term) : ?>
                        <span class="inline-flex items-center rounded-full border border-[#525252] px-[12px] py-[4px] text-[14px] leading-[20px] text-[#525252] shadow-[0px_1px_2px_0px_#0A0D120D]">
                          <?php echo esc_html($term->name); ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

                <div class="mt-[16px] view-more-btn">
                  <a class="inline-flex gap-2 relative" href="<?php the_permalink(); ?>" target="_self">
                    <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('VIEW CASE STUDY', 'mrl-site'); ?></span>
                    <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                  </a>
                </div>
              </div>
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
          <div class="mt-[32px] md:mt-[60px] text-center view-more-btn">
            <button
              id="view-more-case-studies"
              type="button"
              class="inline-flex gap-2 relative cursor-pointer"
              data-current-page="1"
              data-total-pages="<?php echo esc_attr($case_studies_query->max_num_pages); ?>"
            >
                <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('VIEW MORE', 'mrl-site'); ?></span>
                <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
            </button>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const viewMoreButton = document.getElementById('view-more-case-studies');
              const grid = document.getElementById('case-studies-grid');
              const filterSelect = document.getElementById('case-studies-filter');
              const emptyState = document.getElementById('case-studies-empty');
              const loadingText = '<?php echo esc_js(__('LOADING...', 'mrl-site')); ?>';
              const viewMoreText = '<?php echo esc_js(__('VIEW MORE', 'mrl-site')); ?>';
              const viewCaseStudyText = '<?php echo esc_js(__('VIEW CASE STUDY', 'mrl-site')); ?>';
              const taxonomyRestBase = filterSelect ? filterSelect.getAttribute('data-taxonomy-rest-base') : '';

              if (!grid) {
                return;
              }

              let totalPages = viewMoreButton ? parseInt(viewMoreButton.getAttribute('data-total-pages'), 10) : 1;
              let currentPage = viewMoreButton ? parseInt(viewMoreButton.getAttribute('data-current-page'), 10) : 1;
              let isLoading = false;
              let selectedTerm = filterSelect ? parseInt(filterSelect.value, 10) : 0;

              const updateButtonState = function () {
                if (!viewMoreButton) {
                  return;
                }
                if (currentPage >= totalPages) {
                  viewMoreButton.style.display = 'none';
                  viewMoreButton.setAttribute('aria-hidden', 'true');
                } else {
                  viewMoreButton.style.display = '';
                  viewMoreButton.removeAttribute('aria-hidden');
                }
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

                const title = post.title && post.title.rendered ? post.title.rendered : '';
                const featuredImageUrl = getFeaturedImageUrl(post);
                let termsMarkup = '';

                if (post._embedded && post._embedded['wp:term']) {
                  const allTerms = post._embedded['wp:term'].flat();
                  const visibleTerms = taxonomyRestBase
                    ? allTerms.filter(function (term) {
                        return term && term.taxonomy === '<?php echo esc_js($filter_taxonomy); ?>';
                      })
                    : allTerms;
                  termsMarkup = visibleTerms.map(function (term) {
                    return `<span class="inline-flex items-center rounded-full border border-[#CFCFCF] px-[12px] py-[4px] text-[12px] leading-[16px] text-[#737373]">${term.name}</span>`;
                  }).join('');
                }

                article.innerHTML = `
                  <a href="${post.link}" class="block relative blog-card">
                    ${featuredImageUrl ? `
                      <div class="aspect-[1/1]">
                        <img class="w-full h-full object-cover" src="${featuredImageUrl}" alt="${title}" loading="lazy">
                      </div>
                    ` : ''}
                  </a>
                  <div>
                    <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]">
                      <a href="${post.link}" class="hover:opacity-80 transition-opacity">${title}</a>
                    </h2>
                    ${termsMarkup ? `<div class="mt-[14px] flex flex-wrap gap-2">${termsMarkup}</div>` : ''}
                    <div class="mt-[16px] view-more-btn">
                      <a class="inline-flex gap-2 relative" href="${post.link}" target="_self">
                        <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]">${viewCaseStudyText}</span>
                        <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                      </a>
                    </div>
                  </div>
                `;

                grid.appendChild(article);
              };

              const fetchPostsPage = function (page, shouldAppend) {
                if (isLoading || currentPage >= totalPages) {
                  return Promise.resolve();
                }

                isLoading = true;
                const label = viewMoreButton ? viewMoreButton.querySelector('span') : null;
                if (label && shouldAppend) {
                  label.textContent = loadingText;
                }

                const endpoint = new URL(`${window.location.origin}/wp-json/wp/v2/<?php echo esc_js($rest_base); ?>`);
                endpoint.searchParams.set('per_page', '<?php echo esc_js($posts_per_page); ?>');
                endpoint.searchParams.set('page', String(page));
                endpoint.searchParams.set('_embed', '1');
                if (selectedTerm > 0 && taxonomyRestBase) {
                  endpoint.searchParams.set(taxonomyRestBase, String(selectedTerm));
                }

                return fetch(endpoint.toString(), {
                  headers: { 'X-WP-Nonce': '<?php echo esc_js(wp_create_nonce('wp_rest')); ?>' }
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
                  if (viewMoreButton) {
                    viewMoreButton.setAttribute('data-current-page', String(currentPage));
                    viewMoreButton.setAttribute('data-total-pages', String(totalPages));
                  }
                  if (emptyState) {
                    if (grid.children.length === 0) {
                      emptyState.classList.remove('hidden');
                    } else {
                      emptyState.classList.add('hidden');
                    }
                  }
                  updateButtonState();
                })
                .catch(function () {
                  // Keep button available for retry on transient failures.
                })
                .finally(function () {
                  isLoading = false;
                  if (label && shouldAppend) {
                    label.textContent = viewMoreText;
                  }
                });
              };

              if (viewMoreButton) {
                viewMoreButton.addEventListener('click', function () {
                  if (isLoading || currentPage >= totalPages) {
                    return;
                  }
                  fetchPostsPage(currentPage + 1, true);
                });
              }

              if (filterSelect) {
                filterSelect.addEventListener('change', function () {
                  selectedTerm = parseInt(filterSelect.value, 10) || 0;
                  currentPage = 0;
                  totalPages = 1;
                  fetchPostsPage(1, false);
                });
              }

              if (viewMoreButton && !viewMoreButton.getAttribute('data-total-pages')) {
                updateButtonState();
              }

              updateButtonState();
            });
          </script>
        <?php endif; ?>
    </div>
  </section>
  <?php wp_reset_postdata(); ?>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>
<?php get_footer(); ?>
