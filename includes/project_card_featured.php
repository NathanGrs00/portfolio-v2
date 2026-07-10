<?php
?>
<div class="featured-project-card">
    <div class="featured-project-grid">
        <div class="featured-project-card-data">
            <div class="featured-project-meta">
                <?php if (!empty($item['category'])): ?>
                    <span class="featured-project-category"><?= htmlspecialchars($item['category']) ?></span>
                <?php endif; ?>
                <span class="featured-project-tag">FEATURED PROJECT</span>
                <?php if (!empty($item['team_type'])): ?>
                    <span class="featured-project-badge"><?= htmlspecialchars($item['team_type']) ?></span>
                <?php endif; ?>
            </div>

            <h2 class="project-card-title">
                <?= htmlspecialchars($item['name']) ?>
            </h2>
            <p>
                <?= htmlspecialchars($item['short_desc']) ?>
            </p>

            <?php if (!empty($item['role'])): ?>
                <p class="featured-project-role">Role: <?= htmlspecialchars($item['role']) ?></p>
            <?php endif; ?>

            <div class="project-card-techstack">
                <?php foreach (explode(',', $item['tech_stack']) as $tech): ?>
                    <button class="project-tech-badge"><?= htmlspecialchars(trim($tech)) ?></button>
                <?php endforeach; ?>
            </div>

            <div class="project-card-buttons">
                <button class="project-ov-gh-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="#e7e7e7" d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33s1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2" />
                    </svg>
                    Github
                </button>
                <button class="project-ov-view-more-button">
                    View more <i class="ti ti-arrow-right"></i>
                </button>
            </div>
        </div>

        <div class="featured-project-card-media">
            <div class="featured-project-media-box">
                <img src="<?= htmlspecialchars($item['media_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <?php if (!empty($item['video_url'])): ?>
                    <div class="featured-project-play-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M8 5v14l11-7z" />
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <hr/>
</div>