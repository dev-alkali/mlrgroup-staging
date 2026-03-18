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

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center">
      <div class="flex flex-col w-full items-start gap-8 min-[600px]:gap-[60px] max-w-[1920px]">
            <div class="">
              <?php 
                $title1 = get_sub_field('title_row_1');
                $title2 = get_sub_field('title_row_2');
                $subtitle = get_sub_field('subtitle');

              ?>

              <?php if ($title1 || $title2) : ?>
                <h2 class="text-[44px] min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-0.02em] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px] font-heading">
                  <span class="font-bold text-neutral-800"><?php echo wp_kses_post($title1); ?></span>
                  <span class="font-light text-neutral-500"><?php echo wp_kses_post($title2); ?></span>
                </h2>
              <?php endif; ?>

              <?php if ($subtitle) : ?>
                <p class="text-xl leading-7 text-neutral-600 font-body">
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
                  <div class="logo-filter mb-6 w-full text-right">
                      <span>Filter by</span> <select id="industry-filter" class="border rounded px-4 py-2">
                          <option value="all">All Industries</option>
                          <?php foreach ($industries as $industry) : ?>
                              <option value="<?php echo esc_attr($industry); ?>">
                                  <?php echo esc_html($industry); ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                  </div>
              <?php endif; ?>

              <div class="logo-cards grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 w-full">
                  <?php foreach ($logos as $item) :
                      $logo     = $item['logo'];
                      $bg_color = $item['bg_color'];
                      $industry = $item['industry'];
                  ?>
                      <div
                          class="logo-card p-6 flex items-center text-center justify-center aspect-square relative"
                          style="background-color: <?php echo esc_attr($bg_color); ?>;"
                          data-industry="<?php echo esc_attr($industry); ?>"
                      >
                          <?php if ($logo) : ?>
                              <img
                                  src="<?php echo esc_url($logo['url']); ?>"
                                  alt="<?php echo esc_attr($logo['alt']); ?>"
                                  class="max-w-[155px] h-auto"
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
                  <div class="text-center mt-[40px]">
                  <a class="inline-flex  gap-2 relative " href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                      <span class="font-bold text-accent text-lg leading-7 uppercase relative w-fit font-heading tracking-[0]"><?php echo esc_html( $link_title ); ?></span>
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