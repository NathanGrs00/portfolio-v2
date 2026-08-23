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

                $icon = isset($icons[$item['url']])
                    ? $icons[$item['url']]
                    : 'ti-circle';

                if ($section) {
                    $href = '/portfolio-v2/public/index.php#' . $section;
                } else {
                    $href = '/portfolio-v2/public/index.php#top';
                }

            ?>

                <li class="nav-item">

                    <a
                        href="<?= htmlspecialchars($href) ?>"
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

<script src="<?= BASE_URL ?>/assets/js/navbar.js" defer></script>