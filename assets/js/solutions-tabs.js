jQuery(function ($) {
  const swipers = {};

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
    if (swipers[key] || !$slider.is(":visible")) return;

    const el = ensureSwiperMarkup($slider);
    if (!el) return;

    swipers[key] = new Swiper(el, {
      slidesPerView: 4,
      spaceBetween: 20,
      speed: 450,
      watchOverflow: true,
      // centerInsufficientSlides: true,
      navigation: {
        prevEl: $slider.find(".solutions-prev")[0],
        nextEl: $slider.find(".solutions-next")[0],
      },
      pagination: {
        el: $slider.find(".solutions-dots")[0],
        clickable: true,
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
    $(".solutions-tab").removeClass("is-active");
    $('.solutions-tab[data-solution="' + key + '"]').addClass("is-active");

    const $currentSliders = $(".solutions-slider.is-active");
    $currentSliders.each(function () {
      destroySolutionSlider($(this));
      $(this).removeClass("is-active");
    });

    const $nextSlider = $('.solutions-slider[data-solution="' + key + '"]');
    $nextSlider.addClass("is-active");
    initSolutionSlider($nextSlider);

    $(".solutions-columns").removeClass("is-active");
    const $nextColumns = $('.solutions-columns[data-solution="' + key + '"]');
    $nextColumns.addClass("is-active");
  }

  initSolutionSlider($(".solutions-slider.is-active"));

  $(document).on("click", ".source-card .gradient-box", function (e) {
    const targetPath = $(this).attr("href");
    
    if (targetPath && targetPath.startsWith("#")) {
      e.preventDefault();

      const $targetSection = $(targetPath);
      const solutionKey = $(this).find(".card-title").text().trim();

      if ($targetSection.length) {
        $("html, body").animate(
          {
            scrollTop: $targetSection.offset().top - 80,
          },
          600,
        );
      }

      if (solutionKey) {
        activateSolution(solutionKey);
      }
    }
  });

  $(document).on("click", ".solutions-tab", function () {
    const solutionKey = $(this).data("solution");
    activateSolution(solutionKey);
  });
});
