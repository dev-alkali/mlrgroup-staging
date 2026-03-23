
document.addEventListener('DOMContentLoaded', () => {

  gsap.registerPlugin(ScrollTrigger);
  /**------------------------ Animation GSAP -------------------------**/
  const elements = document.querySelectorAll('.anim');

elements.forEach((el) => {

  const delay = parseFloat(el.dataset.delay) || 0;
  const direction = el.dataset.anim || 'up';
  const start = el.dataset.start || 'top 85%';
  const once = el.dataset.once !== 'false';
  
  let x = 0; let y = 0;

  switch (direction) {
    case 'left':
      x = -40; break;
    case 'right':
      x = 40; break;
    case 'down':
      y = 40; break;
    case 'up':
    default:
      y = 40; break;
  }

  ScrollTrigger.create({ trigger: el, start: start, once: once,

    onEnter: () => {
      gsap.fromTo(
        el, { opacity: 0, x: x, y: y },
        { opacity: 1, x: 0, y: 0, delay: delay, duration: 0.7, ease: 'power2.out',
          onStart: () => {
            el.classList.add('is-visible');
          }
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



  var swiper = new Swiper(".reviews-slider-wrapper .reviews-slider", {
    slidesPerView: "auto",
    spaceBetween: 8,
    pagination: {
      el: ".reviews-dots",
      clickable: true,
    },
  });


