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

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> client-logos flex justify-center  px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="w-full wrapper">
            <div class="mb-[32px] md:mb-[60px]">
              <?php 
                $title1 = get_sub_field('title_row_1');
                $title2 = get_sub_field('title_row_2');
                $subtitle = get_sub_field('description');
              ?>

              <?php if ($title1 || $title2) : ?>
                <h2 class="text-[clamp(44px,5vw,68px)] leading-[clamp(56px,6vw,78px)] tracking-[-0.02em] font-heading">
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

              $show_filter   = get_sub_field('filter_display');
              $industries    = $show_filter
                  ? array_unique(array_filter(array_column($logos, 'industry')))
                  : [];
              ?>

              <?php if ($show_filter && ! empty($industries)) : ?>
                  <div class="logo-filter mb-[20px] w-full text-right">
                      <span class="mr-[12px] text-[#525252] text-[16px] font-medium">Filter by</span> <select id="industry-filter" class="">
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

              <div class="logo-cards grid gap-2 flex justify-center flex-wrap lg:w-[calc(25%-6px)] sm:w-[calc(33.33%-6px)] w-[calc(50%-6px)]">
                  <?php foreach ($logos as $item) :
                      $logo     = $item['logo'];
                      $bg_color = $item['bg_color'];
                      $industry = $item['industry'];
                  ?>
                      <div class="logo-card p-6 flex items-center text-center justify-center aspect-square relative"
                          style="background-color: <?php echo esc_attr($bg_color); ?>;"
                          data-industry="<?php echo esc_attr($industry); ?>">
                          <?php if ($logo) : ?>
                              <img
                                  src="<?php echo esc_url($logo['url']); ?>"
                                  alt="<?php echo esc_attr($logo['alt']); ?>"
                                  class="max-w-[90px] md:max-w-[110px] lg:max-w-[155px] h-auto"
                              />
                          <?php endif; ?>
                      </div>
                  <?php endforeach; ?>
              </div>



        <?php 
              $link = get_sub_field('button');
              if( $link ): 
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  ?>
                  <div class="text-center mt-[32px] md:mt-[40px] view-more-btn">
                  <a class="inline-flex  gap-2 relative " href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                      <span class="font-semibold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]"><?php echo esc_html( $link_title ); ?></span>
                      <img decoding="async" class="arrow relative w-4 h-4 mt-1" src="https://wordpress-755960-6249701.cloudwaysapps.com/wp-content/themes/Mlrgroup/assets/imgs/Arrow-red.svg">
                  </a>
              <?php endif; ?>

<?php if ($show_filter) : ?>
<script>
(function () {
    const select = document.getElementById('industry-filter');
    if (!select) return;

    select.addEventListener('change', function () {
        const selected = this.value;
        document.querySelectorAll('.logo-card').forEach(function (card) {
            const match = selected === 'all' || card.dataset.industry === selected;
            card.style.display = match ? '' : 'none';
        });
    });
})();
</script>
<?php endif; ?>

      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?> 