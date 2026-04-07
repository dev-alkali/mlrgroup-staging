<?php

/**
 * Client Logos Block Template.
 */

$id = 'client-logos-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'client-logos';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('client-logos')) : ?>
  <?php while (have_rows('client-logos')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> client-logos flex justify-center px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
      <div class="w-full wrapper">

        <?php
          $title1   = get_sub_field('title_row_1');
          $title2   = get_sub_field('title_row_2');
          $subtitle = get_sub_field('description');
        ?>
        <?php if ($title1 || $title2 || $subtitle) : ?>
          <div class="mb-[32px] md:mb-[60px]">
            <?php if ($title1 || $title2) : ?>
              <h2 class="text-[clamp(36px,6vw,68px)] leading-[clamp(44px,7vw,76px)] tracking-[-0.02em] font-heading">
                <span class="font-bold text-neutral-800"><?php echo wp_kses_post($title1); ?></span>
                <span class="font-light text-neutral-500"><?php echo wp_kses_post($title2); ?></span>
              </h2>
            <?php endif; ?>
            <?php if ($subtitle) : ?>
              <p class="font-body font-normal text-[clamp(18px,1.5vw,20px)] leading-[clamp(26px,2vw,28px)] text-neutral-600 mt-[20px]">
                <?php echo wp_kses_post($subtitle); ?>
              </p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php
          // Collect all logo data upfront — have_rows() can only loop once
          $logos = [];
          if (have_rows('logo_lists')) {
              while (have_rows('logo_lists')) : the_row();
                  $logos[] = [
                      'logo'     => get_sub_field('logo_img'),
                      'bg_color' => get_sub_field('background_color'),
                      'industry' => get_sub_field('industries_filter'),
                  ];
              endwhile;
          }

          $show_filter  = get_sub_field('filter_display');
          $industries   = $show_filter
              ? array_unique(array_filter(array_column($logos, 'industry')))
              : [];

          // Load More config — only active when filter is enabled and logos exceed threshold
          $per_page      = 8;
          $total_logos   = count($logos);
          $show_load_more = $show_filter && $total_logos > $per_page;

          // Unique IDs scoped to this block instance to avoid conflicts when block is used multiple times
          $filter_id = 'industry-filter-' . $block['id'];
          $btn_id    = 'load-more-logos-'  . $block['id'];
        ?>

        <?php if ($show_filter && ! empty($industries)) : ?>
          <div class="logo-filter mb-[20px] w-full text-right">
            <span class="mr-[12px] text-[#525252] text-[16px] font-medium">Filter by</span>
            <select id="<?php echo esc_attr($filter_id); ?>" class="">
              <option value="all">All Industries</option>
              <?php foreach ($industries as $industry) :
                $label = ucwords(str_replace(['-', '_'], ' ', $industry));
              ?>
                <option value="<?php echo esc_attr($industry); ?>">
                  <?php echo esc_html($label); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php endif; ?>

        <div class="logo-cards gap-2 flex justify-center flex-wrap">
          <?php foreach ($logos as $i => $item) :
            $logo     = $item['logo'];
            $bg_color = $item['bg_color'];
            $industry = $item['industry'];
          ?>
            <div class="logo-card p-6 flex items-center text-center justify-center aspect-square relative lg:w-[calc(25%-6px)] sm:w-[calc(33.33%-6px)] w-[calc(50%-6px)]"
                style="background-color: <?php //echo esc_attr($bg_color); ?>;"
                data-industry="<?php echo esc_attr($industry); ?>"
                data-index="<?php echo esc_attr($i); ?>">

              <?php if ($logo) : ?>
                <img
                  src="<?php echo esc_url($logo['url']); ?>"
                  alt="<?php echo esc_attr($logo['alt']); ?>"
                  class="max-w-[90px] md:max-w-[110px] lg:max-w-[155px] xl:max-w-[207px] xl:max-h-[156px] object-contain h-auto"
                />
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if ($show_load_more) : ?>
          <div class="logo-load-more-wrap text-center mt-[32px] md:mt-[40px]">
            <button
              id="<?php echo esc_attr($btn_id); ?>"
              type="button"
              class="logo-sentinel inline-flex gap-2 items-center cursor-pointer bg-transparent border-0 p-0"
              data-per-page="<?php echo esc_attr($per_page); ?>"
              data-loaded="<?php echo esc_attr($per_page); ?>"
              data-total="<?php echo esc_attr($total_logos); ?>">
              <span class="font-semibold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]">Load More</span>
              <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="<?php echo esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-red.svg'); ?>" alt="">
            </button>
          </div>
        <?php endif; ?>

        <?php
          $link = get_sub_field('button');
          if ($link) :
            $link_url    = $link['url'];
            $link_title  = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
          <div class="text-center mt-[32px] md:mt-[40px] view-more-btn">
            <a class="inline-flex gap-2 relative" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
              <span class="font-semibold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]"><?php echo esc_html($link_title); ?></span>
              <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="https://wordpress-755960-6249701.cloudwaysapps.com/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
            </a>
          </div>
        <?php endif; ?>

<?php
if ($show_filter) :
    // Capture values into local variables for the closure.
    // Scripts are deferred to wp_footer so they bypass WordPress content
    // filters (wptexturize etc.) that would corrupt && into &#038;&#038;
    $cl_block_id    = $id;
    $cl_filter_id   = $filter_id;
    $cl_sentinel_id = $btn_id;
    $cl_show_lm     = $show_load_more;

    add_action('wp_footer', function() use ($cl_block_id, $cl_filter_id, $cl_sentinel_id, $cl_show_lm) {
        ?>
        <script>
        (function () {
            var blockId    = "<?php echo esc_js($cl_block_id); ?>";
            var filterId   = "<?php echo esc_js($cl_filter_id); ?>";
            var sentinelId = "<?php echo esc_js($cl_sentinel_id); ?>";
            var showLM     = <?php echo $cl_show_lm ? 'true' : 'false'; ?>;

            console.log('[ClientLogos] Init — blockId:', blockId, '| showLoadMore:', showLM);

            var section = document.getElementById(blockId);
            if (!section) {
                console.warn('[ClientLogos] Section element not found for id:', blockId);
                return;
            }

            var select        = document.getElementById(filterId);
            var sentinel      = showLM ? document.getElementById(sentinelId) : null;
            var cards         = section.querySelectorAll('.logo-card');
            var perPage       = sentinel ? parseInt(sentinel.getAttribute('data-per-page'), 10) : cards.length;
            var loaded        = perPage;
            var currentFilter = 'all';
            var observer      = null;
            var loading       = false;

            console.log('[ClientLogos] Total cards:', cards.length, '| perPage:', perPage, '| sentinel found:', !!sentinel);

            // Initial hide of cards beyond the first batch
            if (sentinel) {
                cards.forEach(function (card) {
                    if (parseInt(card.getAttribute('data-index'), 10) >= loaded) {
                        card.style.display = 'none';
                    }
                });
                console.log('[ClientLogos] Initial render: showing first', loaded, 'of', cards.length, 'cards');
            }

            function revealNext() {
                if (loading) return;
                console.log('[ClientLogos] revealNext triggered — loading:', loading, '| loaded:', loaded, '/', cards.length);
                loading  = true;
                loaded  += perPage;
                applyVisibility();
                // Let browser reflow new cards before re-arming observer
                setTimeout(function () {
                    loading = false;
                    console.log('[ClientLogos] Reflow done — re-attaching observer. Loaded:', loaded, '/', cards.length);
                    attachObserver();
                }, 200);
            }

            function attachObserver() {
                if (observer) { observer.disconnect(); observer = null; }
                if (!sentinel || loaded >= cards.length || currentFilter !== 'all') {
                    console.log('[ClientLogos] attachObserver skipped — all loaded or filter active');
                    return;
                }

                sentinel.style.display = '';

                console.log('[ClientLogos] Observer attached — watching sentinel, loaded so far:', loaded, '/', cards.length);

                observer = new IntersectionObserver(function (entries) {
                    if (!entries[0].isIntersecting || loading) return;
                    console.log('[ClientLogos] Sentinel scrolled into view — auto-triggering next batch');
                    observer.disconnect();
                    observer = null;
                    revealNext();
                }, { rootMargin: '0px 0px 100px 0px' });

                observer.observe(sentinel);
            }

            function applyVisibility() {
                var shown = 0;
                cards.forEach(function (card) {
                    var idx         = parseInt(card.getAttribute('data-index'), 10);
                    var industry    = card.getAttribute('data-industry') || '';
                    var matchFilter = currentFilter === 'all' || industry === currentFilter;

                    if (currentFilter !== 'all') {
                        card.style.display = matchFilter ? '' : 'none';
                        if (matchFilter) shown++;
                    } else {
                        card.style.display = (idx < loaded) ? '' : 'none';
                        if (idx < loaded) shown++;
                    }
                });

                console.log('[ClientLogos] applyVisibility — filter:', currentFilter, '| visible cards:', shown);

                var allLoaded    = loaded >= cards.length;
                var filterActive = currentFilter !== 'all';
                if (sentinel) {
                    var wrap = sentinel.parentElement;
                    if (allLoaded || filterActive) {
                        wrap.style.display = 'none';
                        console.log('[ClientLogos] Load More button hidden —', allLoaded ? 'all cards loaded' : 'filter is active');
                    } else {
                        wrap.style.display = '';
                    }
                }
            }

            // Boot observer on page load
            attachObserver();

            // Manual click fallback — also works as auto-trigger when scrolled into view
            if (sentinel) {
                sentinel.addEventListener('click', function () {
                    console.log('[ClientLogos] Load More clicked manually');
                    if (observer) { observer.disconnect(); observer = null; }
                    revealNext();
                });
            }

            // Filter change
            if (select) {
                select.addEventListener('change', function () {
                    currentFilter = this.value;
                    console.log('[ClientLogos] Filter changed to:', currentFilter);

                    if (observer) { observer.disconnect(); observer = null; }

                    if (currentFilter !== 'all') {
                        cards.forEach(function (card) {
                            var industry = card.getAttribute('data-industry') || '';
                            card.style.display = (industry === currentFilter) ? '' : 'none';
                        });
                        if (sentinel) sentinel.parentElement.style.display = 'none';
                    } else {
                        // Back to "All Industries" — restore pagination then re-arm observer
                        applyVisibility();
                        setTimeout(attachObserver, 50);
                    }
                });
            } else {
                console.warn('[ClientLogos] Filter select not found for id:', filterId);
            }
        })();
        </script>
        <?php
    }, 20);
endif;
?>

      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?>
