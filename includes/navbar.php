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

// Map each stored URL to the id of the section it should scroll to
$sectionMap = array(
    '/'             => null, // null = scroll to top
    '/about.php'    => 'about-section',
    '/projects.php' => 'projects-section',
    '/contact.php'  => 'contact-section',
);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/navbar.css">

<nav class="site-nav" aria-label="Main navigation">
    <div class="nav-inner">
        <a class="nav-brand" href="<?= BASE_URL ?>/">NG</a>

        <button class="nav-toggle" aria-label="Toggle menu"
                onclick="document.querySelector('.nav-items').classList.toggle('open')">
            <i class="ti ti-menu-2" aria-hidden="true"></i>
        </button>

        <ul class="nav-items">
            <?php foreach ($items as $item):
                $section = isset($sectionMap[$item['url']]) ? $sectionMap[$item['url']] : null;
                $href    = $section ? '#' . $section : '#top';
                $icon    = isset($icons[$item['url']]) ? $icons[$item['url']] : 'ti-circle';
                ?>
                <li class="nav-item">
                    <a href="<?= $href ?>"
                       class="nav-link"
                       data-section="<?= $section ? htmlspecialchars($section) : 'top' ?>">
                        <i class="ti <?= $icon ?>" aria-hidden="true"></i>
                        <?= htmlspecialchars($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="nav-right">
            <button class="theme-toggle" aria-label="Toggle theme" onclick="toggleTheme()">
                <i class="ti ti-sun" aria-hidden="true" id="theme-icon"></i>
            </button>
        </div>

    </div>
</nav>


<script>
    function toggleTheme() {
        const isLight = document.body.classList.toggle('light');
        document.getElementById('theme-icon').className = isLight ? 'ti ti-moon' : 'ti ti-sun';
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
    }
    if (localStorage.getItem('theme') === 'light') {
        document.body.classList.add('light');
        document.getElementById('theme-icon').className = 'ti ti-moon';
    }

    // Smooth scroll to sections, offset by navbar height
    document.querySelectorAll('.nav-link, .nav-brand').forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href.startsWith('#')) return;

            e.preventDefault();
            document.querySelector('.nav-items').classList.remove('open');

            const navHeight = document.querySelector('.site-nav').offsetHeight;

            if (href === '#top') {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            const target = document.querySelector(href);
            if (target) {
                const top = target.getBoundingClientRect().top + window.scrollY - navHeight;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    // Highlight the nav link for whichever section is in view
    const sections = document.querySelectorAll('[id$="-section"]');
    const navLinks = document.querySelectorAll('.nav-link');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.toggle('active', link.dataset.section === entry.target.id);
                });
            }
        });
    }, { rootMargin: `-${document.querySelector('.site-nav').offsetHeight + 20}px 0px -60% 0px` });
    sections.forEach(section => observer.observe(section));
</script>