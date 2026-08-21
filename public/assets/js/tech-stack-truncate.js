/**
 * Truncates tech stack badges so they fill the container width
 * without wrapping to a new line. Anything that would overflow
 * is replaced with a "+X more" badge. Re-runs on resize.
 */
(function () {
  function truncateTechStack(container) {
    const badges = Array.from(
      container.querySelectorAll(
        ".project-tech-badge:not(.project-tech-badge-more)",
      ),
    );

    if (badges.length === 0) return;

    // Reveal everything first so we can measure real widths
    badges.forEach((badge) => (badge.style.display = ""));

    const existingMore = container.querySelector(".project-tech-badge-more");
    if (existingMore) existingMore.remove();

    // Bail out if the container isn't actually visible/laid out yet
    // (e.g. hidden by a filter, or width not yet computed).
    const containerWidth = container.clientWidth;
    if (containerWidth === 0) return;

    const gap = parseFloat(getComputedStyle(container).columnGap) || 0;

    // Measure a throwaway "+X more" badge so we know how much space
    // to reserve for it up front.
    const measureMore = document.createElement("span");
    measureMore.className = "project-tech-badge project-tech-badge-more";
    measureMore.style.visibility = "hidden";
    measureMore.style.position = "absolute";
    measureMore.textContent = `+${badges.length} more`;
    container.appendChild(measureMore);
    const moreBadgeWidth = measureMore.offsetWidth;
    measureMore.remove();

    let usedWidth = 0;
    let visibleCount = 0;

    for (let i = 0; i < badges.length; i++) {
      const badgeWidth = badges[i].offsetWidth;
      const gapWidth = i === 0 ? 0 : gap;

      // Reserve room for the "+X more" badge unless this is the last badge
      // (in which case nothing needs to be hidden, so no reservation needed).
      const isLastBadge = i === badges.length - 1;
      const reserve = isLastBadge ? 0 : gap + moreBadgeWidth;

      if (usedWidth + gapWidth + badgeWidth + reserve <= containerWidth) {
        usedWidth += gapWidth + badgeWidth;
        visibleCount++;
      } else {
        break;
      }
    }

    const hiddenCount = badges.length - visibleCount;

    badges.forEach((badge, i) => {
      badge.style.display = i < visibleCount ? "" : "none";
    });

    if (hiddenCount > 0) {
      const moreBadge = document.createElement("span");
      moreBadge.className = "project-tech-badge project-tech-badge-more";
      moreBadge.textContent = `+${hiddenCount} more`;
      container.appendChild(moreBadge);
    }
  }

  function truncateAll() {
    document
      .querySelectorAll(
        ".project-card-techstack, .featured-project-card-techstack",
      )
      .forEach(truncateTechStack);
  }

  // Run after full page load (not just DOMContentLoaded) so fonts/images
  // have settled and container widths are final.
  if (document.readyState === "complete") {
    truncateAll();
  } else {
    window.addEventListener("load", truncateAll);
  }

  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(truncateAll, 150);
  });

  // Expose globally so filter scripts / dynamically shown cards can re-trigger this.
  window.truncateTechStack = truncateAll;
})();
