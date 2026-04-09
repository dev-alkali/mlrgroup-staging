<!-- FOOTER -->
<footer class="flex flex-col w-full">
  <!-- Top Accent Bar -->
  <div class="w-full h-[10px] bg-accent"></div>

  <div class="flex flex-col bg-black w-full">
    <div class="flex flex-col items-center gap-[16] md:gap-28 px-4 md:px-10 pt-[40px] pb-[39px] md:py-20 w-full">
      <div class="flex flex-col max-w-[1920px] items-start gap-16 w-full">
        <div class="flex flex-col min-[1199px]:flex-row w-full lg:justify-between items-start gap-15 min-[1280px]:gap-28">
          <!-- Brand -->
          <div class="flex flex-col max-w-[305px] w-full items-start gap-5">
            <a class="relative max-w-[274px] overflow-hidden flex" href="<?= home_url(); ?>">
              <img class="w-full max-w-[266px] md:max-w-[274px] h-[61.8px]" src="<?= esc_url(get_field('footer_logo', 'option')); ?>" alt="logo">
            </a>
            <div class="flex gap-4 items-center">
              <?php if (have_rows('social_links', 'option')): while (have_rows('social_links', 'option')): the_row(); ?>
                <a href="<?= esc_url(get_sub_field('link')) ?>">
                  <img src="<?= esc_url(get_sub_field('icon')) ?>" alt="" />
                </a>
              <?php endwhile; endif; ?>
            </div>
          </div>

          <!-- Footer Columns -->
          <div class="flex flex-col md:flex-row items-start gap-[13px] md:gap-3 min-[1280px]:gap-8 w-full max-w-[958px] flex-1">
            <?php
            function render_footer_menu($location)
            {
              $locations = get_nav_menu_locations();
              $menu_id   = $locations[$location] ?? 0;
              if (!$menu_id) return;

              $menu_items = wp_get_nav_menu_items($menu_id);
              if (!$menu_items) return;

              // Special Case: Privacy menu (no div, only links)
              if ($location === 'privacy-menu') {
                foreach ($menu_items as $item) {
                  ?>
                  <a class="footer-link" href="<?= esc_url($item->url) ?>"><?= esc_html($item->title) ?></a>
                  <?php
                }
                return;
              }

              // Build tree
              $by_id = [];
              foreach ($menu_items as $it) {
                $it->children = [];
                $by_id[$it->ID] = $it;
              }

              $tree = [];
              foreach ($by_id as $it) {
                $parent_id = (int) $it->menu_item_parent;
                if ($parent_id && isset($by_id[$parent_id])) {
                  $by_id[$parent_id]->children[] = $it;
                } else {
                  $tree[] = $it;
                }
              }

              foreach ($tree as $item):
            ?>
                <div class="footer-item flex flex-col items-start gap-5 w-full flex-1">
                  <div class="footer-title flex justify-between w-full items-center uppercase">
                    <div class="flex gap-1 items-center">
                      <img class="w-4 h-4" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue.svg" alt="">
                      <a href="<?= esc_url($item->url) ?>"><?= esc_html($item->title) ?></a>
                    </div>
                    <span class="dropdown-item-footer min-[600px]:hidden">
                      <img src="<?= get_template_directory_uri() ?>/assets/imgs/Caret-down.svg" alt="">
                    </span>
                  </div>

                  <?php if (!empty($item->children)): ?>
                    <div class="footer-item-content flex flex-col items-start gap-4 pl-2">
                      <?php foreach ($item->children as $child): ?>
                        <a class="footer-text" href="<?= esc_url($child->url) ?>"><?= esc_html($child->title) ?></a>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
            <?php
              endforeach;
            }
            ?>

            <?php render_footer_menu('about-us-menu'); ?>
            <?php render_footer_menu('services-menu'); ?>
            <?php render_footer_menu('work-menu'); ?>

            <!-- Contact Info -->
            <div class="footer-item flex flex-col items-start gap-5 w-full flex-1">
              <div class="footer-title flex justify-between w-full items-center uppercase">
                <div class="flex gap-1 items-center">
                  <img class="w-4 h-4" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-blue.svg" alt="">
                  <a href="<?= home_url(); ?>/contact-us/">Contact</a>
                </div>
                <span class="dropdown-item-footer min-[600px]:hidden">
                  <img src="/wp-content/themes/Mlrgroup/assets/imgs/Caret-down.svg" alt="">
                </span>
              </div>
              <?php if( have_rows('contact_info','option') ): ?>
              <div class="footer-item-content flex flex-col items-start gap-4 pl-2">
                <?php while( have_rows('contact_info','option') ) : the_row(); 
                  $label = get_sub_field('contact_info_label','option');
                  $link = get_sub_field('contact_info_link','option');
                ?>
                  <?php if( $link ): ?>
                    <a class="footer-text" href="<?= esc_url($link); ?>"><?= $label; ?></a>
                  <?php else: ?>
                    <span class="footer-text"><?= $label; ?></span>
                  <?php endif; ?>
                <?php endwhile; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="flex flex-col gap-1 w-full newsletter-gf-container">
          <div class="font-heading font-light text-base leading-6 text-[#F9FAFB] newsletter-gf--text">
            <?= get_field('newsletter_title', 'option'); ?>
          </div>
          <?php
          $form_id = sanitize_text_field(get_field('newsletter_form_id', 'option'));
          if ($form_id) {
            echo do_shortcode('[gravityform id="' . esc_attr($form_id) . '" title="false" description="false" ajax="true"]');
          }
          ?>
        </div>
      </div>

      <!-- Results Images (mobile only) -->
      <div class="flex hidden w-full items-center gap-3">
        <?php if (have_rows('results_images', 'option')): while (have_rows('results_images', 'option')): the_row(); ?>
          <img class="w-[49px] h-[50px]" src="<?= esc_url(get_sub_field('image')) ?>" alt="">
        <?php endwhile; endif; ?>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="flex flex-col items-center gap-16 px-4 md:px-10 py-5 w-full border-t border-[#6e454766]">
      <div class="flex flex-col md:flex-row max-w-[1920px] w-full gap-5 md:gap-5 items-start md:items-center justify-between">
        <p class="footer-text">© 2026 THE MRL GROUP</p>
        <div class="inline-flex gap-5 md:gap-16 footer-privacy-menu max-[768px]:flex-col">
          <?php render_footer_menu('privacy-menu'); ?>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>