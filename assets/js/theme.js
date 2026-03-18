
document.addEventListener('DOMContentLoaded', () => {

  gsap.registerPlugin(ScrollTrigger);
  /**------------------------ Animation GSAP -------------------------**/
  const elements = document.querySelectorAll('.anim');

  elements.forEach((el) => {
    const delay = parseFloat(el.dataset.delay) || 0;
    const direction = el.dataset.anim || 'up';
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

    ScrollTrigger.create({
      trigger: el,
      start: 'top 85%',
      once: true,
      onEnter: () => {
        gsap.fromTo(el, { opacity: 0, x: x, y: y }, {
            opacity: 1, x: 0, y: 0, delay: delay, duration: 0.7, ease: 'power2.out',
            onStart: () => { el.classList.add('is-visible'); }
          }
        );
      }
    });
  });
  /**------------------------ Animation GSAP Ends -------------------------**/

  /**------------------------ Sticky Header -------------------------**/
    const header = document.querySelector('.site-header');
    const hero   = document.querySelector('.c-hero');  

    if (!header || !hero) return;

    ScrollTrigger.create({
        trigger: hero,
        start: 'bottom top',
        onEnter: () => {
        header.classList.add('is-sticky');
        },
        onLeaveBack: () => {
        header.classList.remove('is-sticky');
        }
    });
    /**------------------------ Sticky Header Ends -------------------------**/

});



