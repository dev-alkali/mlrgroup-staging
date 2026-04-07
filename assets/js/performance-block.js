/* global gsap, ScrollTrigger */
document.addEventListener("DOMContentLoaded", () => {
  if (typeof gsap === "undefined") return;
  gsap.registerPlugin(ScrollTrigger);

  const sectionTrigger = document.querySelector(".performance");
  if (!sectionTrigger) return;

  const arrows = gsap.utils.toArray(".arrows-row .arrow");
  const counters = gsap.utils.toArray(".count-box .count-field");

  if (arrows.length) {
    arrows.forEach((a) => a.classList.remove("is-last"));
    arrows[arrows.length - 1].classList.add("is-last");
  }

  gsap.set(arrows, { opacity: 0, x: -24, y: 7 });

  const tl = gsap.timeline({
    paused: true,
    defaults: { ease: "power2.out" },
  });

  tl.to(
    arrows,
    {
      opacity: 1,
      x: 0,
      duration: 4,
      stagger: 0.06,
    },
    0,
  );

  counters.forEach((el) => {
    const originalText = el.textContent.trim();
    const target = parseFloat(originalText);
    if (!Number.isFinite(target)) return;

    const decimals = originalText.includes(".")
      ? originalText.split(".")[1].length
      : 0;

    el.textContent = "0";

    const counter = { value: 0 };

    tl.to(
      counter,
      {
        value: target,
        duration: 4,
        ease: "circ.out",
        onUpdate: () => {
          el.textContent = counter.value.toFixed(decimals);
        },
      },
      0,
    );
  });
  

  
  ScrollTrigger.create({
    trigger: sectionTrigger,
    start: "top 60%",
    once: true,
    onEnter: () => tl.play(),
  });
});
