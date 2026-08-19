let target = window.scrollY;
let current = window.scrollY;
let animationFrame = null;

// Only smooth traditional mouse-wheel scrolling.
// Trackpad/touch scrolling is left to the browser.
window.addEventListener(
  "wheel",
  (event) => {
    // Ignore pinch-to-zoom
    if (event.ctrlKey) return;

    // Trackpads usually produce smaller, more frequent deltas.
    // Mouse wheels usually produce larger, discrete deltas.
    const isLikelyMouseWheel = Math.abs(event.deltaY) >= 30;

    if (!isLikelyMouseWheel) {
      return;
    }

    event.preventDefault();

    target += event.deltaY;

    const maxScroll =
      document.documentElement.scrollHeight - window.innerHeight;

    target = Math.max(0, Math.min(target, maxScroll));

    if (!animationFrame) {
      animationFrame = requestAnimationFrame(smoothScroll);
    }
  },
  { passive: false },
);

function smoothScroll() {
  const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

  const difference = target - current;

  // Snap to exact top/bottom
  if (target <= 0) {
    current = 0;
    target = 0;
    window.scrollTo(0, 0);
    animationFrame = null;
    return;
  }

  if (target >= maxScroll) {
    current = maxScroll;
    target = maxScroll;
    window.scrollTo(0, maxScroll);
    animationFrame = null;
    return;
  }

  // Normal smoothing
  if (Math.abs(difference) < 1) {
    current = target;
    window.scrollTo(0, Math.round(current));
    animationFrame = null;
    return;
  }

  current += difference * 0.1;

  window.scrollTo(0, current);

  animationFrame = requestAnimationFrame(smoothScroll);
}

// If the user touches the screen, immediately synchronize
// our internal position with the browser's native scrolling.
window.addEventListener(
  "scroll",
  () => {
    if (!animationFrame) {
      current = window.scrollY;
      target = window.scrollY;
    }
  },
  { passive: true },
);
