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

  <?php if ($case_studies_query->have_posts()) : ?>
    <section class="px-4 md:px-10 py-[40px] lg:py-[80px] xl:py-[60px]">
      <div class="wrapper">
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
                <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252] mt-[16px] mb-[6px]"><?php echo esc_html(get_the_date()); ?></p>
                <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]">
                  <a href="<?php the_permalink(); ?>" class="hover:opacity-80 transition-opacity"><?php the_title(); ?></a>
                </h2>

                <div class="mt-[16px] view-more-btn">
                  <a class="inline-flex gap-2 relative" href="<?php the_permalink(); ?>" target="_self">
                    <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php esc_html_e('READ MORE', 'mrl-site'); ?></span>
                    <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                  </a>
                </div>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

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
              const loadingText = '<?php echo esc_js(__('LOADING...', 'mrl-site')); ?>';
              const viewMoreText = '<?php echo esc_js(__('VIEW MORE', 'mrl-site')); ?>';

              if (!viewMoreButton || !grid) {
                return;
              }

              const totalPages = parseInt(viewMoreButton.getAttribute('data-total-pages'), 10);
              let currentPage = parseInt(viewMoreButton.getAttribute('data-current-page'), 10);
              let isLoading = false;

              const updateButtonState = function () {
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
                const postDate = new Date(post.date);
                const formattedDate = isNaN(postDate.getTime())
                  ? ''
                  : postDate.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });

                article.innerHTML = `
                  <a href="${post.link}" class="block relative blog-card">
                    ${featuredImageUrl ? `
                      <div class="aspect-[1/1]">
                        <img class="w-full h-full object-cover" src="${featuredImageUrl}" alt="${title}" loading="lazy">
                      </div>
                    ` : ''}
                  </a>
                  <div>
                    <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252] mt-[16px] mb-[6px]">${formattedDate}</p>
                    <h2 class="font-[Poppins] font-bold text-[20px] leading-[28px] tracking-[-0.02em] text-[#262626]">
                      <a href="${post.link}" class="hover:opacity-80 transition-opacity">${title}</a>
                    </h2>
                    <div class="mt-[16px] view-more-btn">
                      <a class="inline-flex gap-2 relative" href="${post.link}" target="_self">
                        <span class="font-semibold text-accent text-[16px] leading-[24px] uppercase relative w-fit font-heading tracking-[0]"><?php echo esc_js(__('READ MORE', 'mrl-site')); ?></span>
                        <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
                      </a>
                    </div>
                  </div>
                `;

                grid.appendChild(article);
              };

              viewMoreButton.addEventListener('click', function () {
                if (isLoading || currentPage >= totalPages) {
                  return;
                }

                isLoading = true;
                const label = viewMoreButton.querySelector('span');
                if (label) {
                  label.textContent = loadingText;
                }

                const nextPage = currentPage + 1;
                const endpoint = `${window.location.origin}/wp-json/wp/v2/<?php echo esc_js($rest_base); ?>?per_page=<?php echo esc_js($posts_per_page); ?>&page=${nextPage}&_embed`;

                fetch(endpoint, {
                  headers: { 'X-WP-Nonce': '<?php echo esc_js(wp_create_nonce('wp_rest')); ?>' }
                })
                .then(function (response) {
                  if (!response.ok) {
                    throw new Error('Failed to fetch case studies');
                  }
                  return response.json();
                })
                .then(function (posts) {
                  posts.forEach(createCard);
                  currentPage = nextPage;
                  viewMoreButton.setAttribute('data-current-page', String(currentPage));
                  updateButtonState();
                })
                .catch(function () {
                  // Keep button available for retry on transient failures.
                })
                .finally(function () {
                  isLoading = false;
                  if (label) {
                    label.textContent = viewMoreText;
                  }
                });
              });

              updateButtonState();
            });
          </script>
        <?php endif; ?>
      </div>
    </section>
  <?php else : ?>
    <section class="px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
      <div class="wrapper">
        <p><?php esc_html_e('No case studies found.', 'score-site'); ?></p>
      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>
<?php get_footer(); ?>
