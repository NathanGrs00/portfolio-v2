<?php
require_once __DIR__ . '/../data/db.php';

$career = supabaseRequest('career?select=*&order=id.asc');

$typeLabels = [
    'school'      => 'Education',
    'internship'  => 'Internship',
    'work'        => 'Work',
];
?>

<link rel="stylesheet" href="/portfolio-v2/public/assets/css/career.css">

<div class="career-section" id="career-section">

    <div class="career-header">
        <h2>Career</h2>
    </div>

    <div class="career-timeline">
        <div class="career-timeline-track"></div>

        <?php foreach ($career as $item): ?>

            <?php
                $type = strtolower(trim($item['type'] ?? ''));
                $typeLabel = $typeLabels[$type] ?? ucfirst($type);
            ?>

            <div class="career-item" data-career-type="<?= htmlspecialchars($type) ?>">

                <div class="career-dot" data-career-type="<?= htmlspecialchars($type) ?>"></div>

                <div class="career-item-content">

                    <span class="career-item-type" data-career-type="<?= htmlspecialchars($type) ?>">
                        <?= htmlspecialchars($typeLabel) ?>
                    </span>

                    <h3 class="career-item-name">
                        <?= htmlspecialchars($item['name']) ?>
                    </h3>

                    <span class="career-item-length type-meta">
                        <?= htmlspecialchars($item['length']) ?>
                    </span>

                    <p class="career-item-desc">
                        <?= nl2br(htmlspecialchars(str_replace('\n', "\n", $item['description']))) ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>