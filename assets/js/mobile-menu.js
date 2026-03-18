jQuery(function ($) {
  const $menu = $(".mobile-menu");
  const $hamb = $(".hamb-group");
  const $close = $(".mobile-menu-close");

  function openMenu() {
    $menu.addClass("open");
    $hamb.addClass("active");
    $("body").addClass("menu-open");
  }

  function closeMenu() {
    $menu.removeClass("open");
    $hamb.removeClass("active");
    $("body").removeClass("menu-open");
  }

  $hamb.on("click", function () {
    openMenu();
  });

  $close.on("click", function () {
    closeMenu();
  });

  $(".mobile-nav-trigger").on("click", function () {
    $(this).siblings('.mobile-submenu').slideToggle('800');
    const $item = $(this).parent();
    $item.toggleClass("open").siblings('.mobile-nav-item').removeClass('open');
  });
});
