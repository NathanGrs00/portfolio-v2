/* ============================================================
   NAVIGATION
   ============================================================ */

const navItems = document.querySelector(".nav-items");
const navToggle = document.querySelector(".nav-toggle");

if (navToggle && navItems) {
  navToggle.addEventListener("click", () => {
    const isOpen = navItems.classList.toggle("open");

    navToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });

  document.addEventListener("click", (event) => {
    const isOpen = navItems.classList.contains("open");

    if (!isOpen) {
      return;
    }

    const clickedInsideMenu = navItems.contains(event.target);
    const clickedToggle = navToggle.contains(event.target);

    if (clickedInsideMenu || clickedToggle) {
      return;
    }

    navItems.classList.remove("open");
    navToggle.setAttribute("aria-expanded", "false");
  });
}

/* ============================================================
   THEME
   ============================================================ */

const themeToggle = document.querySelector(".theme-toggle");

function applyTheme(theme) {
  const root = document.documentElement;
  const icon = document.getElementById("theme-icon");

  root.setAttribute("data-theme", theme);

  if (icon) {
    icon.className = theme === "light" ? "ti ti-moon" : "ti ti-sun";
  }

  localStorage.setItem("theme", theme);
}

function toggleTheme() {
  const currentTheme =
    document.documentElement.getAttribute("data-theme") || "light";

  const nextTheme = currentTheme === "light" ? "dark" : "light";

  applyTheme(nextTheme);
}

if (themeToggle) {
  themeToggle.addEventListener("click", toggleTheme);
}

/* ============================================================
   RESTORE SAVED THEME
   ============================================================ */

const savedTheme = localStorage.getItem("theme");

if (savedTheme === "dark" || savedTheme === "light") {
  applyTheme(savedTheme);
} else {
  applyTheme("light");
}

/* ============================================================
   ACTIVE SECTION (shared state, used by both scroll-spy and
   the click handler below)
   ============================================================ */

const sections = document.querySelectorAll('[id$="-section"]');
const navLinks = document.querySelectorAll(".nav-link");
const nav = document.querySelector(".site-nav");

const setActive = (id) => {
  navLinks.forEach((link) => {
    link.classList.toggle("active", link.dataset.section === id);
  });
};

/*
 * While true, the IntersectionObserver callbacks are ignored.
 * This is turned on right when a nav link is clicked (since we
 * already know the destination) and turned back off once the
 * smooth-scroll animation has settled, so the observer doesn't
 * flicker the active tab for sections passed through mid-flight.
 */
let suppressScrollSpy = false;
let suppressTimeout = null;

if (sections.length && navLinks.length) {
  const navHeight = nav?.offsetHeight || 0;

  const sectionsArray = Array.from(sections);
  const lastSection = sectionsArray[sectionsArray.length - 1];
  const otherSections = sectionsArray.slice(0, -1);

  const intersecting = new Map(
    sectionsArray.map((section) => [section.id, false]),
  );

  const recomputeActive = () => {
    if (suppressScrollSpy) {
      return;
    }

    /*
     * When multiple sections are intersecting at once (common
     * right at a boundary, since the two observers use
     * different zones), prefer the LAST one in document order.
     */
    let current = null;

    for (const section of sectionsArray) {
      if (intersecting.get(section.id)) {
        current = section;
      }
    }

    if (current) {
      setActive(current.id);
    }
  };

  const handleEntries = (entries) => {
    entries.forEach((entry) => {
      intersecting.set(entry.target.id, entry.isIntersecting);
    });

    recomputeActive();
  };

  const observer = new IntersectionObserver(handleEntries, {
    rootMargin: `-${navHeight + 20}px 0px -60% 0px`,
  });

  otherSections.forEach((section) => {
    observer.observe(section);
  });

  const lastObserver = new IntersectionObserver(handleEntries, {
    rootMargin: `-${navHeight + 20}px 0px 0px 0px`,
  });

  lastObserver.observe(lastSection);
}

/*
 * Called right before we kick off a programmatic smooth scroll.
 * Locks in the active tab immediately and pauses scroll-spy
 * until the scroll settles, so intermediate sections passed
 * through mid-animation don't flicker the active state.
 */
function lockActiveDuringScroll(id) {
  setActive(id);

  suppressScrollSpy = true;

  clearTimeout(suppressTimeout);

  if ("onscrollend" in window) {
    const resume = () => {
      suppressScrollSpy = false;
      window.removeEventListener("scrollend", resume);
    };

    window.addEventListener("scrollend", resume);

    /*
     * Safety net in case scrollend never fires for some reason
     * (e.g. scroll gets interrupted with 0 distance).
     */
    suppressTimeout = setTimeout(() => {
      suppressScrollSpy = false;
      window.removeEventListener("scrollend", resume);
    }, 1200);
  } else {
    /*
     * Fallback for browsers without scrollend support
     * (older Safari). Smooth scrolls typically settle well
     * under a second even over long distances.
     */
    suppressTimeout = setTimeout(() => {
      suppressScrollSpy = false;
    }, 1000);
  }
}

/* ============================================================
   SMOOTH SECTION SCROLL
   ============================================================ */

document
  .querySelectorAll(".nav-link, .nav-brand, .about-view-more")
  .forEach((link) => {
    link.addEventListener("click", function (event) {
      const href = this.getAttribute("href");

      if (!href) {
        return;
      }

      /*
       * Convert the href into a URL so we can determine
       * whether the link points to this page or another page.
       */
      const url = new URL(href, window.location.href);

      const isSamePage = url.pathname === window.location.pathname;

      const hasHash = url.hash && url.hash.length > 1;

      if (!isSamePage) {
        return;
      }

      if (!hasHash) {
        return;
      }

      event.preventDefault();

      /*
       * Close mobile navigation.
       */
      if (navItems) {
        navItems.classList.remove("open");
      }

      if (navToggle) {
        navToggle.setAttribute("aria-expanded", "false");
      }

      const navHeightNow = nav ? nav.offsetHeight : 0;

      /*
       * Home / top.
       */
      if (url.hash === "#top") {
        lockActiveDuringScroll("top");

        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });

        return;
      }

      const target = document.querySelector(url.hash);

      if (!target) {
        return;
      }

      lockActiveDuringScroll(target.id);

      const top =
        target.getBoundingClientRect().top + window.scrollY - navHeightNow;

      window.scrollTo({
        top,
        behavior: "smooth",
      });
    });
  });
