<?php
?>
<div class="project-card">
    <div class="project-grid">
        <div class="project-card-media">
            <div class="project-card-media-box">
                <img
                    src="<?= htmlspecialchars($item['media_url']) ?>"
                    alt="<?= htmlspecialchars($item['name']) ?>"
                >
            </div>
        </div>

        <div class="project-card-data">
            <h2 class="project-card-title">
                <?= htmlspecialchars($item['name']) ?>
            </h2>

            <p>
                <?= nl2br(htmlspecialchars(str_replace('\n', "\n", $item['short_desc']))) ?>
            </p>

            <div class="project-card-techstack">

                <?php foreach (explode(',', $item['tech_stack']) as $tech): ?>

                    <?php
                        $techName = trim($tech);
                        $techKey = strtolower($techName);
                        $techData = $technologies[$techKey] ?? null;
                    ?>

                    <?php if ($techData): ?>

                        <span
                            class="project-tech-badge"
                            style="--tech-color: <?= htmlspecialchars($techData['color']) ?>"
                        >
                            <?= htmlspecialchars($techData['tech_name']) ?>
                        </span>

                    <?php else: ?>

                        <span class="project-tech-badge">
                            <?= htmlspecialchars($techName) ?>
                        </span>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
            <span class="project-role">
                <?= htmlspecialchars($item['role']) ?>
            </span>
        </div>

        <div class="project-card-buttons">
            <?php if (!empty($item['github_url'])): ?>
                <a
                    href="<?= htmlspecialchars($item['github_url']) ?>"
                    class="project-ov-gh-button"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="View on GitHub"
                >
                    <i class="ti ti-brand-github"></i>
                        Github
                </a>
            <?php endif; ?>

            <a href="/portfolio-v2/public/project.php?id=<?= urlencode($item['id']) ?>" class="project-ov-view-more-button">
                View more
            </a>
        </div>
    </div>

    <hr/>
</div>