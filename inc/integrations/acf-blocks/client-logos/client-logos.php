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
              data-per-page="<?php echo esc_attr($per_page); ?>"
              data-loaded="<?php echo esc_attr($per_page); ?>"
              data-total="<?php echo esc_attr($total_logos); ?>"
              class="inline-flex gap-2 relative cursor-pointer">
              <span class="font-semibold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]">Load More</span>
              <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="https://wordpress-755960-6249701.cloudwaysapps.com/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg" alt="">
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

<?php if ($show_filter) : ?>
<script>
(function () {
    var blockId   = <?php echo json_encode($id); ?>;
    var filterId  = <?php echo json_encode($filter_id); ?>;
    var btnId     = <?php echo json_encode($btn_id); ?>;
    var showLM    = <?php echo $show_load_more ? 'true' : 'false'; ?>;

    var section   = document.getElementById(blockId);
    if (!section) return;

    var select      = document.getElementById(filterId);
    var loadMoreBtn = showLM ? document.getElementById(btnId) : null;
    var cards       = section.querySelectorAll('.logo-card');
    var perPage     = loadMoreBtn ? parseInt(loadMoreBtn.getAttribute('data-per-page'), 10) : cards.length;
    var loaded      = perPage;
    var currentFilter = 'all';

    // Hide cards beyond the first page on initial load
    if (loadMoreBtn) {
        cards.forEach(function (card) {
            if (parseInt(card.getAttribute('data-index'), 10) >= loaded) {
                card.style.display = 'none';
            }
        });
    }

    function applyVisibility() {
        cards.forEach(function (card) {
            var idx         = parseInt(card.getAttribute('data-index'), 10);
            var industry    = card.getAttribute('data-industry') || '';
            var matchFilter = currentFilter === 'all' || industry === currentFilter;

            if (currentFilter !== 'all') {
                // Filter active: show ALL matching logos, ignore pagination
                card.style.display = matchFilter ? '' : 'none';
            } else {
                // No filter: respect the loaded cursor
                card.style.display = (idx < loaded) ? '' : 'none';
            }
        });

        if (loadMoreBtn) {
            var wrap = loadMoreBtn.parentElement;
            if (currentFilter !== 'all') {
                // Hide Load More while a filter is active
                wrap.style.display = 'none';
            } else {
                wrap.style.display = (loaded < cards.length) ? '' : 'none';
            }
        }
    }

    if (select) {
        select.addEventListener('change', function () {
            currentFilter = this.value;
            applyVisibility();
        });
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            loaded += perPage;
            loadMoreBtn.setAttribute('data-loaded', loaded);
            applyVisibility();
        });
    }
})();
</script>
<?php endif; ?>

      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?>
