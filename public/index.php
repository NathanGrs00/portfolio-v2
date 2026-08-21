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

    <link rel="stylesheet" href="/portfolio-v2/public/assets/css/index.css">
    <link rel="stylesheet" href="/portfolio-v2/public/assets/css/contact.css">
    <link rel="stylesheet" href="/portfolio-v2/public/assets/css/footer.css">
</head>

<body id="top">

<?php include '../includes/navbar.php'; ?>

<main class="main-content">

    <?php
    include 'about.php';
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
            © <?= date('Y') ?> · Built with intention
        </span>

        <a href="#top" class="footer-top">
            Back to top
            <i class="ti ti-arrow-up"></i>
        </a>

    </div>
</footer>

<script src="/portfolio-v2/public/assets/js/smoothing.js"></script>
<script src="/portfolio-v2/public/assets/js/project-filter.js"></script>
<script
    src="/portfolio-v2/public/assets/js/tech-stack-truncate.js"
    defer
></script>

</body>
</html>