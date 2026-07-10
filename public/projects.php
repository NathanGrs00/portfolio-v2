<?php
require_once __DIR__ . '/../data/db.php';

/** @var PDO $pdo */
$stmt = $pdo->query("SELECT * FROM projects");
?>

<link rel="stylesheet" href="/portfolio-v2/public/assets/css/projects.css">

<div class="projects-section">
    <h1 class="projects-section-title">Projects</h1>

    <div class="project-list">
        <?php $isFirst = true; ?>
        <?php while ($item = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <?php if ($isFirst): ?>
                <?php include __DIR__ . '/../includes/project_card_featured.php'; ?>
                <?php $isFirst = false; ?>
            <?php else: ?>
                <?php include __DIR__ . '/../includes/project_card.php'; ?>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>