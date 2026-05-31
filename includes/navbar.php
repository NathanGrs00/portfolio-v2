<?php
require_once __DIR__ . '/../data/db.php';

/** @var PDO $pdo */
$stmt = $pdo->query("SELECT * FROM navigation WHERE active = 1");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$active = $_SERVER['REQUEST_URI'];
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<nav class="site-nav" aria-label="Main navigation">
    <div class="nav-inner">
        <a class="nav-brand" href="<?= BASE_URL ?>/">NG</a>
        <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false"
                onclick="this.setAttribute('aria-expanded',
                    document.querySelector('.nav-items').classList.toggle('open'));
                ">&#9776;</button>

        <ul class="nav-items">
            <?php foreach ($items as $item):
                $isActive = rtrim(BASE_URL . $item['url'], '/') === rtrim($active, '/');
                ?>
                <li class="nav-item">
                    <a href="<?= BASE_URL . htmlspecialchars($item['url']) ?>"
                       class="nav-link<?= $isActive ? ' active' : '' ?>">
                        <?= htmlspecialchars($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
</nav>

