<?php

/**
 * header.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class=" absolute z-50 flex w-full justify-center items-center min-[600px]:px-5 min-[600px]:pt-5">
    <div class="site-header anim hidden min-[1180px]:flex self-stretch flex-[0_0_auto] px-10  min-[1250px]:px-20  min-[600px]:pt-8">
      <div class="wrapper min-[1180px]:flex justify-between w-full">
         <div class="relative w-[140px] h-8">
          <?php
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            $logo_svg = get_field('logo_svg', 'option');
          ?>

          <?php
            
              if ($logo_svg): ?>
                <a class="site-header__logo-image" href="<?php echo esc_url(home_url('/')); ?>">
                  <?php echo $logo_svg; ?>
                </a>
              <?php else: ?>
                <a class="site-header__logo-image" href="<?php echo esc_url(home_url('/')); ?>">
                  <img src="<?= $logo_url ?>" alt="MLR Group">
                </a>
              <?php endif; ?>
          </div>
          <div class="site-header__nav inline-flex items-center gap-5 min-[1350px]:gap-10 flex-[0_0_auto] anim" data-delay="1.2" data-anim="up">
            <nav>
              <?php
              $locations = get_nav_menu_locations();
              $menu_id   = $locations['header-menu'] ?? 0;

              if ($menu_id) {
                $menu_items = wp_get_nav_menu_items($menu_id);
                if ($menu_items) {
                  $current_url = home_url($_SERVER['REQUEST_URI']);
                  $current_url_normalized = trailingslashit($current_url);

                  // Indexa por ID + cria array children
                  $by_id = [];
                  foreach ($menu_items as $it) {
                    $it->children = [];
                    $by_id[$it->ID] = $it;
                  }

                  // Monta árvore
                  $tree = [];
                  foreach ($by_id as $it) {
                    $parent_id = (int) $it->menu_item_parent;
                    if ($parent_id && isset($by_id[$parent_id])) {
                      $by_id[$parent_id]->children[] = $it;
                    } else {
                      $tree[] = $it;
                    }
                  }
              ?>

                  <!-- wrapper novo (não muda suas classes existentes) -->
                  <div class="inline-flex items-center gap-6">
                    <?php foreach ($tree as $item): ?>
                      <?php
                      $item_url_normalized = trailingslashit($item->url);
                      $active_class = ($item_url_normalized === $current_url_normalized) ? 'active' : '';
                      $has_children = !empty($item->children);
                      $index = 1;
                      ?>

                      <!-- wrapper novo por item -->
                      <div class="site-nav__item <?= $has_children ? 'has-children' : '' ?> anim" data-delay="<?php echo $index; $index  = $index + 0.1; ?>" data-anim="up">
                        <a class="inline-flex items-center justify-center gap-2"
                          href="<?= esc_url($item->url) ?>"
                          <?= $has_children ? 'aria-haspopup="true" aria-expanded="false"' : '' ?>>
                          <span class="flex gap-2 <?= esc_attr($active_class) ?>">
                            <?php if ($active_class == "active"): ?>
                              <img class="w-4 h-4 mt-[2px]" src="https://c.animaapp.com/mmah2hinwUF90F/img/arrow.svg" alt="" />
                            <?php endif; ?>
                            <span class="nav-link "><?= esc_html($item->title) ?></span>
                          </span>

                          <?php if ($has_children): ?>
                            <!-- NÃO MUDA: mesma imagem, agora condicional -->
                            <img class="w-5 h-5 site-nav__caret"
                              src="https://c.animaapp.com/mmah2hinwUF90F/img/frame.svg" alt="" />
                          <?php endif; ?>
                        </a>

                        <?php if ($has_children): ?>
                          <!-- dropdown (classes novas) -->
                          <div class="site-nav__dropdown">
                            <?php foreach ($item->children as $child): ?>
                              <?php
                              $child_url_normalized = trailingslashit($child->url);
                              $child_active_class = ($child_url_normalized === $current_url_normalized) ? 'active' : '';
                              ?>
                              <a class="site-nav__dropdown-link <?= esc_attr($child_active_class) ?>"
                                href="<?= esc_url($child->url) ?>">
                                <?= esc_html($child->title) ?>
                              </a>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      </div>

                    <?php endforeach; ?>
                  </div>
              <?php
                }
              } else {
                echo '<p>empty menu</p>';
              }
              ?>
            </nav>
            <a class="btn-primary" href="<?= esc_url(get_field('lets_talk_link', 'option')) ?>">LETS TALK</a>
          </div>
      </div>
    </div>
    <div class="header-dropdown flex w-full justify-between items-center min-[1180px]:hidden self-stretch flex-[0_0_auto] px-4 min-[600px]:px-10 min-[890px]:px-20  pt-4 min-[600px]:pt-8 pb-4  min-[600px]:pb-0 wrapper">
      <div class="relative w-[106px] min-[600px]:w-[120px]  ">
        <?php
        $logo_id = get_theme_mod('custom_logo');
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img src="<?= $logo_url ?>" alt="MLR Group">
        </a>
      </div>
      <div class="mobile-menu site-header anim ">
        <div class="mobile-menu-header px-4 min-[600px]px-15  min-[1250px]:px-25 pt-6 min-[600px]:pt-13 wrapper">

          <div class="relative w-[106px] min-[600px]:w-[120px]">

            <?php
            if ($logo_svg): ?>
              <a class="site-header__logo-image site-header__logo-image--mobile" href="<?php echo esc_url(home_url('/')); ?>">
                <?php echo $logo_svg; ?>
              </a>
            <?php endif; ?>
          </div>

          <button class="mobile-menu-close">
            <img src="<?= get_template_directory_uri() ?>/assets/imgs/Remove.svg" alt="close">
          </button>

        </div>
        <div class="mobile-menu-inner">

          <nav class="mobile-nav">
            <?php foreach ($tree as $item): ?>
              <?php
              $item_url_normalized = trailingslashit($item->url);
              $active_class = ($item_url_normalized === $current_url_normalized) ? 'is-active' : '';
              ?>
              <?php $has_children = !empty($item->children); ?>

              <div class="mobile-nav-item  <?= $has_children ? 'has-children' : '' ?> >

                <span  class="mobile-nav-trigger <?= $active_class  ?>">
                  <a href="<?= esc_url($item->url) ?>" class="mobile-item-name"><?= esc_html($item->title) ?></a>

                  <?php if ($has_children): ?>
                    <span class="mobile-nav-arrow"></span>
                  <?php endif; ?>
                </span>

                <?php if ($has_children): ?>
                  <div class="mobile-submenu">
                    <?php foreach ($item->children as $child): ?>
                      <a href="<?= esc_url($child->url) ?>">
                        <?= esc_html($child->title) ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

              </div>

            <?php endforeach; ?>
          </nav>

          <div class="mobile-menu-footer">
            <a class="btn-primary" href="<?= esc_url(get_field('lets_talk_link', 'option')) ?>">LET'S TALK</a>
          </div>

        </div>

      </div>
      <div class="hamb-group">
        <img src="<?= get_template_directory_uri() ?>/assets/imgs/Menu.svg" alt="">
      </div>
    </div>
  </header>