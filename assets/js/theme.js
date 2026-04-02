document.addEventListener('DOMContentLoaded', () => {
  const gradientTransformTransition = 'transform 0.85s ease';

  document.querySelectorAll('.gradient-box').forEach(card => {
    const figure  = card.querySelector('figure');
    const content = card.querySelector('.content');
    if (!figure || !content) return;

    figure.style.transition  = gradientTransformTransition;
    content.style.transition = gradientTransformTransition;

    card.addEventListener('mouseenter', () => {
      const cardH    = card.offsetHeight;
      const figH     = figure.offsetHeight;
      const contentH = content.offsetHeight;
      const py       = parseFloat(getComputedStyle(card).paddingTop);

      figure.style.transform  = `translateY(${cardH - (2 * py) - figH}px)`;
      content.style.transform = `translateY(-${cardH - (2 * py) - contentH}px)`;
    });

    card.addEventListener('mouseleave', () => {
      figure.style.transform  = '';
      content.style.transform = '';
    });
  });
});



document.addEventListener('DOMContentLoaded', () => {
  gsap.registerPlugin(ScrollTrigger);

  // Prevent scroll restoration jump
  if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
  }
  window.scrollTo(0, 0);

  /**------------------------ Animation GSAP -------------------------**/
  const elements = document.querySelectorAll('.anim');
  elements.forEach((el) => {
    const delay = parseFloat(el.dataset.delay) || 0;
    const direction = el.dataset.anim || 'up';
    const start = el.dataset.start || 'top 85%';
    const once = el.dataset.once !== 'false';
    let x = 0; let y = 0;
    switch (direction) {
      case 'left':  x = -40; break;
      case 'right': x = 40;  break;
      case 'down':  y = 40;  break;
      case 'up':
      default:      y = 40;  break;
    }
    ScrollTrigger.create({
      trigger: el, start: start, once: once,
      onEnter: () => {
        gsap.fromTo(
          el,
          { opacity: 0, x: x, y: y },
          {
            opacity: 1, x: 0, y: 0, delay: delay, duration: 0.7, ease: 'power2.out',
            onStart: () => { el.classList.add('is-visible'); }
          }
        );
      }
    });
  });

  /**------------------------ Animation GSAP Ends -------------------------**/

  /**------------------------ Sticky Header -------------------------**/
  // const header = document.querySelector('.site-header');
  // const hero   = document.querySelector('.c-hero');

  //   if (!header) return;

  //   // If hero exists 
  //   if (hero) {
  //     ScrollTrigger.create({
  //       trigger: hero,
  //       start: 'bottom top',

  //       onEnter: () => {
  //         header.classList.add('is-sticky');
  //       },
  //       onLeaveBack: () => {
  //         header.classList.remove('is-sticky');
  //       }
  //     });

  //   } else {
  //     ScrollTrigger.create({
  //       start: 'top -100vh',
  //       onEnter: () => {
  //         header.classList.add('is-sticky');
  //       },
  //       onLeaveBack: () => {
  //         header.classList.remove('is-sticky');
  //       }
  //     });
  //   }

  const header = document.querySelector('.site-header');
  if (!header) return;

  // Trigger header after 100vh scroll
  ScrollTrigger.create({
    start: 'top+=100% top', // 100% of viewport height scrolled
    onEnter: () => header.classList.add('is-sticky'),
    onLeaveBack: () => header.classList.remove('is-sticky')
  });
    /**------------------------ Sticky Header Ends -------------------------**/

});



document.querySelectorAll(".reviews-slider-wrapper").forEach((slider) => {
  new Swiper(slider, {
    slidesPerView: "auto",
    spaceBetween: 8,
    pagination: {
      el: slider.querySelector(".reviews-dots"),
      clickable: true,
    },
  });
});

let question = document.querySelectorAll(".question");

question.forEach(question => {
  question.addEventListener("click", event => {
    const active = document.querySelector(".question.active");
    if(active && active !== question ) {
      active.classList.toggle("active");
      active.nextElementSibling.style.maxHeight = 0;
    }
    question.classList.toggle("active");
    const answer = question.nextElementSibling;
    if(question.classList.contains("active")){
      answer.style.maxHeight = answer.scrollHeight + "px";
    } else {
      answer.style.maxHeight = 0;
    }
  })
})


/* Work Sidebar */

jQuery(document).ready(function ($) {

  const $sidebar = $(".sidebar-cat");
  const $toggleBtn = $(".filter-toggle-btn");
  const $heading = $(".filter-heading");


  function toggleSidebar() {
    $toggleBtn.toggleClass("change-btn");
    $sidebar.stop(true, true).slideToggle(300);
  }

  $toggleBtn.on("click", function (e) {
    e.stopPropagation();
    toggleSidebar();
  });

  $heading.on("click", function () {
    toggleSidebar();
  });


  $("[data-toggle]").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $arrow = $(this);
    const $li = $arrow.closest("li");
    const $childList = $li.find(".child-list").first();

    if (!$childList.length) return;

    // close others (optional - remove if not needed)
    $li.siblings().find(".child-list:visible").slideUp(300);
    // Keep arrow rotation consistent with the collapsed state
    $li.siblings().find("[data-toggle]").addClass("rotate-180");

    // toggle current
    $childList.stop(true, true).slideToggle(300);
    $arrow.toggleClass("rotate-180");
  });

});