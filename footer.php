<!-- FOOTER -->
<footer class=" flex flex-col w-full">
  <div class="w-full h-5 bg-accent"></div>

  <div class="flex flex-col items-start w-full bg-black">
    <div class="flex flex-col items-center gap-[60px] min-[600px]:gap-[120px] px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-20 w-full">
      <div class="flex flex-col max-w-[1920px]  items-start gap-[60px] w-full">
        <div class="flex flex-col min-[1000px]:flex-row  w-full min-[1441px]:justify-between items-start gap-[60px] min-[600px]:gap-28">
          <!-- Brand -->
          <div class="flex flex-col max-w-[305px] w-full items-start gap-5">
            <div class="relative  max-w-[274px] overflow-hidden">

              <img class="w-full max-w-[266px] min-[600px]:max-w-[274px] h-[61.8px]" src="<?= esc_url(get_field('footer_logo', 'option')); ?>" alt="logo">
            </div>
            <div class="flex gap-4 items-center">
              <?php if (have_rows('social_links', 'option')): while (have_rows('social_links', 'option')): the_row(); ?>
                  <a href="<?= esc_url(get_sub_field('link')) ?>">
                    <img src="<?= esc_url(get_sub_field('icon')) ?>" alt="" />
                  </a>

              <?php endwhile;
              endif; ?>
            </div>

          </div>

          <!-- Columns -->
          <div class="flex items-start flex-col min-[600px]:flex-row gap-8 w-full max-w-[863px] flex-1">
            <?php
            function render_footer_menu($location)
            {

              $locations = get_nav_menu_locations();
              $menu_id   = $locations[$location] ?? 0;

              if (!$menu_id) return;

              $menu_items = wp_get_nav_menu_items($menu_id);
              if (!$menu_items) return;

              // SPECIAL CASE: privacy menu (NO DIV, only links)
              if ($location === 'privacy-menu') {
                foreach ($menu_items as $item) {
                  ?>
                  <a class="footer-link" href="<?= esc_url($item->url) ?>">
                    <?= esc_html($item->title) ?>
                  </a>
                  <?php
                }
                return; // stop further structure
              }

             
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

             
              foreach ($tree as $item) {
            ?>

                <div class="footer-item flex flex-col items-start min-[600px]:gap-5 w-full flex-1">

                  <div class=" footer-title flex justify-center gap-1 w-full">
                    <img class="w-4 h-4" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow-blue.svg" alt="">
                    <div class="footer-title flex justify-between w-full uppercase flex-1">
                     <a href="<?= esc_url($item->url) ?>"><?= esc_html($item->title) ?></a> 
                      <span class="dropdown-item-footer  min-[600px]:hidden">
                        <img src="<?= get_template_directory_uri() ?>/assets/imgs/Caret-down.svg" alt="">
                      </span>
                    </div>
                  </div>

                  <?php if (!empty($item->children)): ?>

                    <div class="footer-item-content  flex flex-col items-start gap-4 pl-2">

                      <?php foreach ($item->children as $child): ?>

                        <a class="footer-text" href="<?= esc_url($child->url) ?>">
                          <?= esc_html($child->title) ?>
                        </a>

                      <?php endforeach; ?>

                    </div>

                  <?php endif; ?>

                </div>

            <?php
              }
            }
            ?>
            <?php render_footer_menu('about-us-menu'); ?>

            <?php render_footer_menu('services-menu'); ?>

            <?php render_footer_menu('work-menu'); ?>

            <?php //render_footer_menu('contacts-menu'); ?>

            <div class="footer-item flex flex-col items-start min-[600px]:gap-5 w-full flex-1">
              <div class=" footer-title flex justify-center gap-1 w-full">
                <img class="w-4 h-4" src="/wp-content/themes/Mlrgroup/assets/imgs/Arrow-blue.svg" alt="">
                <div class="footer-title flex justify-between w-full uppercase flex-1">
                  <a href="#">Contact</a> 
                  <span class="dropdown-item-footer  min-[600px]:hidden"><img src="/wp-content/themes/Mlrgroup/assets/imgs/Caret-down.svg" alt=""></span>
                </div>
              </div>
              <?php if( have_rows('contact_info','option') ): ?>
              <div class="footer-item-content  flex flex-col items-start gap-4 pl-2">                      
                  <?php while( have_rows('contact_info','option') ) : the_row(); 
                      $label = get_sub_field('contact_info_label','option');
                      $link = get_sub_field('contact_info_link','option');
                  ?>
                      <?php if( $link ): ?>
                          <a class="footer-text" href="<?php echo esc_url($link); ?>"><?php echo $label; ?></a>
                      <?php else: ?>
                          <span class="footer-text" ><?php echo $label; ?></span>
                      <?php endif; ?>                            
                  <?php endwhile; ?>                    
              </div>
              <?php endif; ?>

            </div>
          </div>
        </div>

        <!-- Newsletter -->

        <div class="flex flex-col gap-5 w-full newsletter-gf-container">
          <div class="font-[poppins] font-medium text-base leading-6 tracking-normal text-[#F9FAFB]"><?php echo get_field('newsletter_title', 'option'); ?> </div>
          <?php
          $form_id = sanitize_text_field(get_field('newsletter_form_id', 'option'));

          if ($form_id) {

            echo do_shortcode('[gravityform id="' . esc_attr($form_id) . '" title="false" description="false" ajax="true"]');
          }
          ?>
        </div>
      </div>
      <div class="flex min-[600px]:hidden w-full items-center gap-3">
        <?php if (have_rows('results_images', 'option')): while (have_rows('results_images', 'option')): the_row(); ?>
            <img class="w-[49px] h-[50px]" src="<?= esc_url(get_sub_field('image')) ?>" alt="">
        <?php endwhile;
        endif; ?>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="flex flex-col items-center gap-[60px] px-4 md:px-10 py-5 w-full border-t border-[#6e454766]">
      <div class="flex max-w-[1920px] w-full gap-5 flex-col md:flex-row md:gap-5 w-full items-start md:items-center justify-between">
          <p class="footer-text">© 2026 THE MRL GROUP</p>
          <div class="inline-flex gap-5 md:gap-[60px] footer-privacy-menu">
            <?php render_footer_menu('privacy-menu'); ?>
          </div>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>