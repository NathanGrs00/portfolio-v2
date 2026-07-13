<?php
require_once __DIR__ . '/../data/db.php';

$projects = supabaseRequest('projects?select=*');
?>
<link rel="stylesheet" href="/portfolio-v2/public/assets/css/projects.css">
<div class="projects-section">
    <div class="project-list">
        <?php foreach ($projects as $index => $item): ?>
            <?php if ($index === 0): ?>
                <?php include __DIR__ . '/../includes/project_card_featured.php'; ?>
            <?php else: ?>
                <?php include __DIR__ . '/../includes/project_card.php'; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>