<?php
require_once __DIR__ . '/../data/db.php';

$technologyRows = supabaseRequest('tech?select=tech_name,color');

$technologies = [];

foreach ($technologyRows as $technology) {
    $key = strtolower(trim($technology['tech_name']));
    $technologies[$key] = $technology;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nathan Geers | Portfolio</title>

    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="icon" href="/assets/img/logo_v2.png" type="image/x-icon">
</head>

<body id="top">

<div id="preloader">
    <svg viewBox="0 0 120 120" width="80" height="80" class="preloader-svg">
        <circle
            cx="60" cy="60" r="50"
            fill="none"
            stroke="currentColor"
            stroke-width="4"
            stroke-linecap="round"
            stroke-dasharray="80 220"
            class="preloader-ring"
        />
        <text
            x="60" y="60"
            text-anchor="middle"
            dominant-baseline="central"
            class="preloader-letters"
        >NG</text>
    </svg>
</div>

<?php include '../includes/navbar.php'; ?>

<main class="main-content">

    <?php
    include 'about.php';
    include '../includes/career.php';
    include 'projects.php';
    include 'contact.php';
    ?>

</main>

<footer class="site-footer">
    <div class="footer-inner">

        <span class="footer-name">
            Nathan Geers
        </span>

        <span class="footer-meta">
            © <?= date('Y') ?> · Built with love!
        </span>

        <a href="#top" class="footer-top">
            Back to top
            <i class="ti ti-arrow-up"></i>
        </a>

    </div>
</footer>

<script src="/assets/js/preloader.js"></script>
<script src="/assets/js/project-filter.js"></script>
<script
    src="/assets/js/tech-stack-truncate.js"
    defer
></script>

</body>
</html>