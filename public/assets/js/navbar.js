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

      /*
       * If this is another page, allow the browser to navigate
       * normally.
       *
       * Example:
       * /portfolio-v2/public/index.php#projects-section
       */
      if (!isSamePage) {
        return;
      }

      /*
       * No hash means this isn't a section link.
       */
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

      /*
       * Calculate navbar height.
       */
      const nav = document.querySelector(".site-nav");

      const navHeight = nav ? nav.offsetHeight : 0;

      /*
       * Home / top.
       */
      if (url.hash === "#top") {
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });

        return;
      }

      /*
       * Find the section on the current page.
       */
      const target = document.querySelector(url.hash);

      if (!target) {
        return;
      }

      /*
       * Scroll to the section while accounting
       * for the fixed navbar.
       */
      const top =
        target.getBoundingClientRect().top + window.scrollY - navHeight;

      window.scrollTo({
        top,
        behavior: "smooth",
      });
    });
  });

/* ============================================================
   ACTIVE SECTION
   ============================================================ */

const sections = document.querySelectorAll('[id$="-section"]');

const navLinks = document.querySelectorAll(".nav-link");

const nav = document.querySelector(".site-nav");

if (sections.length && navLinks.length) {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        navLinks.forEach((link) => {
          link.classList.toggle(
            "active",
            link.dataset.section === entry.target.id,
          );
        });
      });
    },

    {
      rootMargin: `-${(nav?.offsetHeight || 0) + 20}px 0px -60% 0px`,
    },
  );

  sections.forEach((section) => {
    observer.observe(section);
  });
}
