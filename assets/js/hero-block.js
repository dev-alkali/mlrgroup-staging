
/* global gsap */
document.addEventListener("DOMContentLoaded", () => {
  if (typeof gsap === "undefined") return;

  const words = document.querySelectorAll('.rotating-anim .rotate-text');
  if (words.length <= 1) return;

  let currentIndex = 0;

  function changeText() {
    const currentWord = words[currentIndex];
    currentIndex = (currentIndex + 1) % words.length;
    const nextWord = words[currentIndex];

    const tl = gsap.timeline();

    tl.to(currentWord, {
      duration: 0.5,
      opacity: 0,
      y: -15,
      ease: "power2.in",
      onComplete: () => {

        currentWord.style.display = "none";
      }
    })
 
    .call(() => {
      nextWord.style.display = "inline-block";
    })

    .fromTo(nextWord, 
      { opacity: 0, y: 15 },
      {
        duration: 0.5,
        opacity: 1,
        y: 0,
        ease: "power2.out"
      }
    );
  }


  setInterval(changeText, 4000);
});