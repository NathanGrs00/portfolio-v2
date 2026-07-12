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
                $isActive = rtrim(BASE_URL . $item['url'], '/') === rtrim($active, '/');
                $icon     = isset($icons[$item['url']]) ? $icons[$item['url']] : 'ti-circle';
                ?>
                <li class="nav-item">
                    <a href="<?= BASE_URL . htmlspecialchars($item['url']) ?>"
                       class="nav-link<?= $isActive ? ' active' : '' ?>">
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
</script>