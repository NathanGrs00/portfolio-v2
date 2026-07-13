<?php
?>
<div class="featured-project-card">
    <div class="featured-project-grid">
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

            <div class="featured-project-card-techstack">
                <?php foreach (explode(',', $item['tech_stack']) as $tech): ?>
                    <button class="project-tech-badge"><?= htmlspecialchars(trim($tech)) ?></button>
                <?php endforeach; ?>
            </div>

            <div class="project-card-buttons">
                <button class="project-ov-gh-button">
                    <i class="ti ti-brand-github"></i>
                    Github
                </button>
                <button class="project-ov-view-more-button">
                    View more <i class="ti ti-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
    <hr/>
</div>