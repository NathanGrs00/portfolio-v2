<?php
require_once __DIR__ . '/../data/db.php';

$technologyRows = supabaseRequest('tech?select=tech_name,color');

$technologies = [];

foreach ($technologyRows as $technology) {
    $key = strtolower(trim($technology['tech_name']));
    $technologies[$key] = $technology;
}

include '../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nathan Geers | Portfolio</title>
    <link rel="stylesheet" href="/portfolio-v2/public/assets/css/index.css">
</head>

<body>

<div class="main-content">
    <?php
    include 'about.php';
    include 'projects.php';
    include 'contact.php';
    ?>
</div>
<script src="/portfolio-v2/public/assets/js/smoothing.js"></script>
<script src="/portfolio-v2/public/assets/js/project-filter.js"></script>
</body>
</html>