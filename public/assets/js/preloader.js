document.body.classList.add("preloading");

window.addEventListener("load", () => {
  const preloader = document.getElementById("preloader");
  if (!preloader) return;

  preloader.classList.add("loaded");
  document.body.classList.remove("preloading");

  // Remove from DOM entirely after the fade-out transition ends
  preloader.addEventListener(
    "transitionend",
    () => {
      preloader.remove();
    },
    { once: true },
  );
});
