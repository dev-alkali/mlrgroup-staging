jQuery(function ($) {
  const swipers = {};

  // Returns how many slides are visible at current viewport width
  function getSlidesPerView() {
    const w = window.innerWidth;
    if (w >= 1440) return 4;
    if (w >= 1024) return 3;
    return 1;
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
      $wrapper = $track.children(".swiper-wrapper");
    } else {
      $wrapper.children().addClass("swiper-slide");
    }

    return $track[0];
  }

  function initSolutionSlider($slider) {
    const key = $slider.data("solution");

    // Skip if already initialised or not visible
    if (swipers[key] || !$slider.is(":visible")) return;

    const $track = $slider.find(".solutions-track").first();
    if (!$track.length) return;

    // Count real slides BEFORE any DOM wrapping
    const slideCount = $track
      .children()
      .not(".solutions-prev, .solutions-next, .solutions-dots").length;

    // Only init Swiper when slides exceed what fits in view
    if (slideCount <= getSlidesPerView()) return;

    const el = ensureSwiperMarkup($slider);
    if (!el) return;

    swipers[key] = new Swiper(el, {
      slidesPerView: 4,
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
        1024: {
          slidesPerView: 3,
        },
        1440: {
          slidesPerView: 4,
        },
      },
    });
  }

  function destroySolutionSlider($slider) {
    const key = $slider.data("solution");
    if (!swipers[key]) return;
    swipers[key].destroy(true, true);
    delete swipers[key];
  }

  function activateSolution(key) {
    // Update tab active state
    $(".solutions-tab").removeClass("is-active");
    $('.solutions-tab[data-solution="' + key + '"]').addClass("is-active");

    // Destroy & deactivate current slider
    const $currentSliders = $(".solutions-slider.is-active");
    $currentSliders.each(function () {
      destroySolutionSlider($(this));
      $(this).removeClass("is-active");
    });

    // Activate & init next slider only if it needs Swiper
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
    const solutionKey = $(this).data("solution");
    activateSolution(solutionKey);
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

      if (solutionKey) {
        activateSolution(solutionKey);
      }
    }
  });

  // Resize handler — re-evaluate active slider
  let resizeTimer;
  $(window).on("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      const $activeSlider = $(".solutions-slider.is-active");
      if (!$activeSlider.length) return;

      const key = $activeSlider.data("solution");

      if (swipers[key]) {
        // Swiper exists — just update it
        swipers[key].update();
      } else {
        // Swiper doesn't exist yet — try to init (viewport may have grown)
        initSolutionSlider($activeSlider);
      }
    }, 200);
  });
});