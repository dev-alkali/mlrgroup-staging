jQuery(function ($) {
  const swipers = {};

  // Must match your Swiper breakpoints
  function getSlidesPerView() {
    const w = window.innerWidth;
    if (w >= 1440) return 4;
    if (w >= 1024) return 3;
    return 1;
  }

  // Apply static equal-column flex layout (no Swiper needed)
  function applyStaticLayout($slider, count) {
    const $track = $slider.find(".solutions-track").first();

    // FIX #1 — hide nav/pagination when no slider needed
    $slider.find(".solutions-prev, .solutions-next, .solutions-dots").hide();

    $track
      .css({ display: "flex", flexWrap: "nowrap", gap: "20px" })
      .attr("data-static-cols", count);

    $track.children()
      .not(".solutions-prev, .solutions-next, .solutions-dots")
      .css({
        flex: "1 1 0%",
        minWidth: "0",
        maxWidth: count === 1 ? "100%" : "",
      });
  }

  // Remove static layout styles
  function removeStaticLayout($slider) {
    const $track = $slider.find(".solutions-track").first();
    if (!$track.attr("data-static-cols")) return;

    // FIX #1 — restore nav/pagination visibility
    $slider.find(".solutions-prev, .solutions-next, .solutions-dots").show();

    $track
      .css({ display: "", flexWrap: "", gap: "" })
      .removeAttr("data-static-cols");

    $track.children()
      .not(".solutions-prev, .solutions-next, .solutions-dots")
      .css({ flex: "", minWidth: "", maxWidth: "" });
  }

  function ensureSwiperMarkup($slider) {
    const $track = $slider.find(".solutions-track").first();
    if (!$track.length) return null;

    $track.addClass("swiper");

    let $wrapper = $track.children(".swiper-wrapper");
    if (!$wrapper.length) {
      const $slides = $track
        .children()
        .not(".solutions-prev, .solutions-next, .solutions-dots");
      $slides.addClass("swiper-slide");
      $slides.wrapAll('<div class="swiper-wrapper"></div>');
    } else {
      $wrapper.children().addClass("swiper-slide");
    }

    return $track[0];
  }

  // FIX #2 — fully reset DOM so re-init works cleanly
  function resetSwiperMarkup($slider) {
    const $track = $slider.find(".solutions-track").first();
    if (!$track.length) return;

    $track.removeClass("swiper");

    const $wrapper = $track.find(".swiper-wrapper");
    if ($wrapper.length) {
      $wrapper.children().removeClass("swiper-slide").unwrap();
    }
  }

  function initSolutionSlider($slider) {
    const key = $slider.data("solution");
    if (swipers[key] || !$slider.is(":visible")) return;

    const $track = $slider.find(".solutions-track").first();
    if (!$track.length) return;

    // Count real slides before any DOM changes
    const slideCount = $track
      .children()
      .not(".solutions-prev, .solutions-next, .solutions-dots").length;

    const perView = getSlidesPerView();

    if (slideCount <= perView) {
      // FIX #1 — static equal-column layout, no Swiper, no nav
      applyStaticLayout($slider, slideCount);
      return;
    }

    // Enough slides — init Swiper
    const el = ensureSwiperMarkup($slider);
    if (!el) return;

    swipers[key] = new Swiper(el, {
      slidesPerView: 3,
      spaceBetween: 20,
      speed: 450,
      watchOverflow: true,
      navigation: {
        prevEl: $slider.find(".solutions-prev")[0],
        nextEl: $slider.find(".solutions-next")[0],
      },
      pagination: {
        el: $slider.find(".solutions-dots")[0],
        clickable: true,
      },
      breakpoints: {
        1024: { slidesPerView: 3 },
        1440: { slidesPerView: 4 },
      },
    });
  }

  function destroySolutionSlider($slider) {
    const key = $slider.data("solution");

    if (swipers[key]) {
      swipers[key].destroy(true, true);
      delete swipers[key];
      // FIX #2 — reset DOM so next init starts from a clean state
      resetSwiperMarkup($slider);
    }

    // Remove static layout if it was applied
    removeStaticLayout($slider);
  }

  function activateSolution(key) {
    $(".solutions-tab").removeClass("is-active");
    $('.solutions-tab[data-solution="' + key + '"]').addClass("is-active");

    // Destroy & deactivate current slider
    $(".solutions-slider.is-active").each(function () {
      destroySolutionSlider($(this));
      $(this).removeClass("is-active");
    });

    // Activate & init next slider
    const $nextSlider = $('.solutions-slider[data-solution="' + key + '"]');
    $nextSlider.addClass("is-active");
    initSolutionSlider($nextSlider);

    // Mobile columns
    $(".solutions-columns").removeClass("is-active");
    $('.solutions-columns[data-solution="' + key + '"]').addClass("is-active");
  }

  // Init the first active slider on page load
  initSolutionSlider($(".solutions-slider.is-active"));

  // Tab click
  $(document).on("click", ".solutions-tab", function () {
    activateSolution($(this).data("solution"));
  });

  // Source card anchor click (scroll + activate tab)
  $(document).on("click", ".source-card .gradient-box", function (e) {
    const targetPath = $(this).attr("href");

    if (targetPath && targetPath.startsWith("#")) {
      e.preventDefault();

      const $targetSection = $(targetPath);
      const solutionKey = $(this).find(".card-title").text().trim();

      if ($targetSection.length) {
        $("html, body").animate(
          { scrollTop: $targetSection.offset().top - 80 },
          600
        );
      }

      if (solutionKey) activateSolution(solutionKey);
    }
  });

  // Resize — re-evaluate active slider
  let resizeTimer;
  $(window).on("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      const $activeSlider = $(".solutions-slider.is-active");
      if (!$activeSlider.length) return;

      destroySolutionSlider($activeSlider);
      initSolutionSlider($activeSlider);
    }, 200);
  });
});