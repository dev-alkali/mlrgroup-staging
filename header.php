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
  <script>
  if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
  }
  window.scrollTo(0, 0);
</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<?php
$is_transparent_page = is_archive() || is_tax() || is_category() || is_tag() || is_home();
$acf_schema          = get_field('header_schema');

if ( $is_transparent_page ) {
    $header_schema = 'absolute min-[1024px]:pt-[52px] light-skin';
} elseif ( $acf_schema === 'light-skin' ) {
    $header_schema = 'absolute min-[1024px]:pt-[52px]';
} else {
    $header_schema = 'relative dark-skin min-[1024px]:py-4';
}
?>
<?php //$header_schema = get_field('header_schema') == 'light-skin' ? 'absolute min-[1024px]:pt-[52px]' : 'relative dark-skin min-[1024px]:py-4';?>

<header class=" <?php echo $header_schema.' '.get_field('header_schema'); ?> z-[99] w-full site-header px-4 min-[600px]:px-10 min-[767px]:px-20 lg:px-[100px]">
  
  <?php
  $locations = get_nav_menu_locations();
  $menu_id   = $locations['header-menu'] ?? 0;

  $tree = [];
  $current_url_normalized = trailingslashit(home_url($_SERVER['REQUEST_URI']));

  if ($menu_id) {
    $menu_items = wp_get_nav_menu_items($menu_id);

    if ($menu_items) {
      $by_id = [];

      foreach ($menu_items as $it) {
        $it->children = [];
        $by_id[$it->ID] = $it;
      }

      foreach ($by_id as $it) {
        $parent_id = (int) $it->menu_item_parent;
        if ($parent_id && isset($by_id[$parent_id])) {
          $by_id[$parent_id]->children[] = $it;
        } else {
          $tree[] = $it;
        }
      }
    }
  }

  $logo_id  = get_theme_mod('custom_logo');
  $logo_url = wp_get_attachment_image_url($logo_id, 'full');
  $logo_svg = get_field('logo_svg', 'option');
  $mobile_menu_logo = get_field('mobile_menu_logo', 'option');
  ?>

  <!-- DESKTOP HEADER -->
  <div class="hidden min-[1180px]:flex self-stretch flex-[0_0_auto] w-full max-w-[1752px] mx-auto">
    <div class="dark-reset-x  min-[1180px]:flex justify-between w-full items-center mx-auto min-[767px]:px-20">

    <!-- LOGO -->
      <div class="relative w-[140px] h-8">
        <a class="site-header__logo-image" href="<?php echo esc_url(home_url('/')); ?>">
          <?php if ($logo_svg): ?>
            <?php echo $logo_svg; ?>
          <?php elseif ($logo_url): ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
          <?php endif; ?>
        </a>
      </div>

      <!-- NAV -->
      <div class="site-header__nav inline-flex items-center gap-5 min-[1350px]:gap-10 flex-[0_0_auto]">

        <nav>
          <div class="inline-flex items-center gap-6 site-header_nav-list">
            <?php
            $index = 2.45;
            foreach ($tree as $item):
              $item_url_normalized = trailingslashit($item->url);
              $active_class = ($item_url_normalized === $current_url_normalized) ? 'active' : '';
              $has_children = !empty($item->children);
            ?>

              <div class="site-nav__item relative <?php echo $has_children ? 'has-children' : ''; ?>">

                <a class="nav-link inline-flex items-center justify-center gap-2"
                   href="<?php echo esc_url($item->url); ?>"
                   <?php echo $has_children ? 'aria-haspopup="true" aria-expanded="false"' : ''; ?>>

                  <span class="flex gap-2 <?php echo esc_attr($active_class); ?>">
                    <?php if ($active_class === "active"): ?>
                      <img class="w-4 h-4 mt-[2px]" src="https://c.animaapp.com/mmah2hinwUF90F/img/arrow.svg" alt="">
                    <?php endif; ?>

                    <span class="nav-link__title"><?php echo esc_html($item->title); ?></span>
                  </span>

                  <?php if ($has_children): ?>
                    <div class="w-5 h-5 site-nav__caret">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M10 14c-.6 0-1.2-.2-1.6-.7L3 7.9c-.2-.2-.2-.6 0-.8.2-.2.6-.2.8 0l5.4 5.4c.4.4 1 .4 1.4 0l5.4-5.4c.2-.2.6-.2.8 0 .2.2.2.6 0 .8l-5.4 5.4c-.4.5-1 .7-1.6.7z" fill="var(--arrow-color, #11171E)"/>
                      </svg>
                    </div>
                  <?php endif; ?>
                </a>

                <?php if ($has_children): ?>
                  <div class="site-nav__dropdown min-[1180px]:absolute min-[1180px]:left-0 min-[1180px]:top-full min-[1180px]:bg-white min-[1180px]:px-[20px] min-[1180px]:py-[28px] min-[1180px]:shadow-lg">
                    <?php foreach ($item->children as $child):
                      $child_url_normalized = trailingslashit($child->url);
                      $child_active_class = ($child_url_normalized === $current_url_normalized) ? 'active' : '';
                    ?>
                      <a class="site-nav__dropdown-link block py-2 min-w-[250px] font-semibold font-heading leading-[22px] <?php echo esc_attr($child_active_class); ?>"
                         href="<?php echo esc_url($child->url); ?>">
                        <?php echo esc_html($child->title); ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

              </div>

            <?php endforeach; ?>
          </div>
        </nav>

        <?php if(get_field('lets_talk_link', 'option')): ?>
        <a class="btn-primary anim" href="<?php echo esc_url(get_field('lets_talk_link', 'option')); ?>"  data-delay="<?php echo $index ? : 3.85; ?>" data-anim="up">LETS TALK</a>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <!-- MOBILE HEADER -->
  <div class="header-dropdown flex w-full justify-between items-center min-[1180px]:hidden py-4">

    <!-- LOGO -->
    <div class="relative w-[106px] md:w-[120px]">
      <a class="site-header__logo-image" href="<?php echo esc_url(home_url('/')); ?>">
        <?php if ($logo_svg): ?>
          <?php echo $logo_svg; ?>
        <?php elseif ($logo_url): ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
        <?php endif; ?>
      </a>
      <?php if ($mobile_menu_logo): ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-menu-logo hidden"><img src="<?php echo esc_url($mobile_menu_logo['url']); ?>" alt="<?php echo esc_attr($mobile_menu_logo['alt']); ?>" class="h-[23px] w-auto"></a>
      <?php endif; ?>
    </div>

     <button class="mobile-menu-close">
        <img src="<?= get_template_directory_uri() ?>/assets/imgs/Remove.svg" alt="close">
      </button>

    <!-- MOBILE MENU -->
    <div class="mobile-menu">
      <div class="mobile-menu-inner">

        <nav class="mobile-nav">
          <?php foreach ($tree as $item):
            $item_url_normalized = trailingslashit($item->url);
            $active_class = ($item_url_normalized === $current_url_normalized) ? 'is-active' : '';
            $has_children = !empty($item->children);
          ?>

            <div class="mobile-nav-item <?php echo $has_children ? 'has-children' : ''; ?>">

              <span class="mobile-nav-trigger <?php echo esc_attr($active_class); ?>">
                <a href="<?php echo esc_url($item->url); ?>" class="mobile-item-name uppercase">
                  <?php echo esc_html($item->title); ?>
                </a>

                <?php if ($has_children): ?>
                  <span class="mobile-nav-arrow"></span>
                <?php endif; ?>
              </span>

              <?php if ($has_children): ?>
                <div class="mobile-submenu">
                  <?php foreach ($item->children as $child): ?>
                    <a href="<?php echo esc_url($child->url); ?>">
                      <?php echo esc_html($child->title); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

            </div>

          <?php endforeach; ?>
        </nav>

        <div class="mobile-menu-footer">
          <?php if(get_field('lets_talk_link', 'option')): ?>
            <a class="btn-primary" href="<?php echo esc_url(get_field('lets_talk_link', 'option')); ?>">LETS TALK</a>
          <?php endif; ?>

        </div>

      </div>
    </div>

    <!-- HAMBURGER -->
    <div class="hamb-group anim" data-delay="3" data-anim="up">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/Menu.svg" alt="menu">
    </div>

  </div>

</header>
