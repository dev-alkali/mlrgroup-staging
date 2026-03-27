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
    <div id="case-studies-grid">
    <?php while ($case_studies_query->have_posts()) : $case_studies_query->the_post(); ?>
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

          const escapeHtml = function (unsafe) {
            return String(unsafe || '')
              .replace(/&/g, '&amp;')
              .replace(/</g, '&lt;')
              .replace(/>/g, '&gt;')
              .replace(/"/g, '&quot;')
              .replace(/'/g, '&#039;');
          };

          const createCard = function (post) {
            const article = document.createElement('article');
            article.id = 'post-' + post.id;
            article.className = 'post type-' + '<?php echo esc_js($post_type); ?>' + ' status-publish';

            const title = post.title && post.title.rendered ? post.title.rendered : '';
            const excerpt = post.excerpt && post.excerpt.rendered ? post.excerpt.rendered : '';
            const featured = post._embedded && post._embedded['wp:featuredmedia'] && post._embedded['wp:featuredmedia'][0]
              ? post._embedded['wp:featuredmedia'][0]
              : null;
            const imageUrl = featured && featured.source_url ? featured.source_url : '';

            article.innerHTML = `
              <header class="entry-header">
                <h2 class="entry-title"><a href="${post.link}">${title}</a></h2>
              </header>
              ${imageUrl ? `
                <div class="post-thumbnail">
                  <a href="${post.link}">
                    <img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(title)}" loading="lazy">
                  </a>
                </div>
              ` : ''}
              <div class="entry-content">
                ${excerpt}
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
  <?php else : ?>
    <p><?php esc_html_e('No case studies found.', 'score-site'); ?></p>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>
<?php get_footer(); ?>
