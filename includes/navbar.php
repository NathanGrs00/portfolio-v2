<?php
require_once __DIR__ . '/../data/db.php';

$items = supabaseRequest('navigation?select=*&active=eq.1');

$active = $_SERVER['REQUEST_URI'];

$icons = array(
    '/'             => 'ti-home',
    '/projects.php' => 'ti-briefcase',
    '/about.php'    => 'ti-user',
    '/contact.php'  => 'ti-mail',
);

$sectionMap = array(
    '/'             => null,
    '/about.php'    => 'about-section',
    '/projects.php' => 'projects-section',
    '/contact.php'  => 'contact-section',
);
?>

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"
>

<link
    rel="stylesheet"
    href="<?= BASE_URL ?>/assets/css/navbar.css"
>


<nav class="site-nav" aria-label="Main navigation">

    <div class="nav-inner">

        <a
            class="nav-brand"
            href="<?= BASE_URL ?>/"
            aria-label="Nathan Geers — Home"
        >
            NG
        </a>


        <button
            class="nav-toggle"
            type="button"
            aria-label="Toggle menu"
            aria-expanded="false"
            onclick="toggleNav()"
        >
            <i
                class="ti ti-menu-2"
                aria-hidden="true"
            ></i>
        </button>


        <ul class="nav-items">

            <?php foreach ($items as $item):

                $section = isset($sectionMap[$item['url']])
                    ? $sectionMap[$item['url']]
                    : null;

                $href = $section
                    ? '#' . $section
                    : '#top';

                $icon = isset($icons[$item['url']])
                    ? $icons[$item['url']]
                    : 'ti-circle';

            ?>

                <li class="nav-item">

                    <a
                        href="<?= $href ?>"
                        class="nav-link"
                        data-section="<?= $section
                            ? htmlspecialchars($section)
                            : 'top'
                        ?>"
                    >

                        <i
                            class="ti <?= htmlspecialchars($icon) ?>"
                            aria-hidden="true"
                        ></i>

                        <?= htmlspecialchars($item['label']) ?>

                    </a>

                </li>

            <?php endforeach; ?>

        </ul>


        <div class="nav-right">

            <button
                class="theme-toggle"
                type="button"
                aria-label="Toggle theme"
                onclick="toggleTheme()"
            >
                <i
                    class="ti ti-sun"
                    aria-hidden="true"
                    id="theme-icon"
                ></i>
            </button>

        </div>

    </div>

</nav>


<script>
/* ============================================================
   NAVIGATION
   ============================================================ */

function toggleNav() {

    const navItems = document.querySelector('.nav-items');
    const navToggle = document.querySelector('.nav-toggle');

    if (!navItems || !navToggle) {
        return;
    }

    const isOpen = navItems.classList.toggle('open');

    navToggle.setAttribute(
        'aria-expanded',
        isOpen ? 'true' : 'false'
    );
}


/* ============================================================
   THEME
   ============================================================ */

function applyTheme(theme) {

    const root = document.documentElement;
    const icon = document.getElementById('theme-icon');

    root.setAttribute('data-theme', theme);

    if (icon) {
        icon.className =
            theme === 'light'
                ? 'ti ti-moon'
                : 'ti ti-sun';
    }

    localStorage.setItem('theme', theme);
}


function toggleTheme() {

    const currentTheme =
        document.documentElement.getAttribute('data-theme')
        || 'light';

    const nextTheme =
        currentTheme === 'light'
            ? 'dark'
            : 'light';

    applyTheme(nextTheme);
}


/* ============================================================
   RESTORE SAVED THEME
   ============================================================ */

(function () {

    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark' || savedTheme === 'light') {
        applyTheme(savedTheme);
    } else {
        applyTheme('light');
    }

})();


/* ============================================================
   SMOOTH SECTION SCROLL
   ============================================================ */

document.querySelectorAll(
    '.nav-link, .nav-brand'
).forEach(link => {

    link.addEventListener('click', function (event) {

        const href = this.getAttribute('href');

        if (!href || !href.startsWith('#')) {
            return;
        }

        event.preventDefault();

        const navItems =
            document.querySelector('.nav-items');

        if (navItems) {
            navItems.classList.remove('open');
        }

        const navToggle =
            document.querySelector('.nav-toggle');

        if (navToggle) {
            navToggle.setAttribute(
                'aria-expanded',
                'false'
            );
        }

        const nav =
            document.querySelector('.site-nav');

        const navHeight =
            nav ? nav.offsetHeight : 0;


        if (href === '#top') {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            return;
        }


        const target =
            document.querySelector(href);

        if (!target) {
            return;
        }

        const top =
            target.getBoundingClientRect().top
            + window.scrollY
            - navHeight;


        window.scrollTo({
            top,
            behavior: 'smooth'
        });

    });

});


/* ============================================================
   ACTIVE SECTION
   ============================================================ */

const sections =
    document.querySelectorAll('[id$="-section"]');

const navLinks =
    document.querySelectorAll('.nav-link');

const nav =
    document.querySelector('.site-nav');


if (sections.length && navLinks.length) {

    const observer =
        new IntersectionObserver(

            entries => {

                entries.forEach(entry => {

                    if (!entry.isIntersecting) {
                        return;
                    }

                    navLinks.forEach(link => {

                        link.classList.toggle(
                            'active',
                            link.dataset.section === entry.target.id
                        );

                    });

                });

            },

            {
                rootMargin:
                    `-${(nav?.offsetHeight || 0) + 20}px 0px -60% 0px`
            }

        );


    sections.forEach(section => {
        observer.observe(section);
    });

}
</script>