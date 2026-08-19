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

                <span class="project-role">
                    <?= htmlspecialchars($item['role']) ?>
                </span>

            </div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            fill="#e7e7e7"
                            d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33s1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71.78 1.08.78 2.17 0 1.57-.01 2.83-.01 3.22c0 .31.2.67.8.56A10.99 10.99 0 0 0 22 12A10 10 0 0 0 12 2"
                        />
                    </svg>
                </a>
            <?php endif; ?>

            <button class="project-ov-view-more-button">
                View more
            </button>
        </div>
    </div>

    <hr/>
</div>