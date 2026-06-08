<?php
?>
<div class="project-card">
    <div class="project-grid">
        <div class="project-card-media">
            <div class="project-card-media-box">
                <img src="<?= htmlspecialchars($item['media_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            </div>
        </div>
        <div class="project-card-data">
            <h2 class="project-card-title">
                <?= htmlspecialchars($item['name']) ?>
            </h2>
            <p>
                <?= htmlspecialchars($item['short_desc']) ?>
            </p>
        </div>
        <div class="project-card-buttons">
            <button class="project-ov-gh-button">
                GH
            </button>
            <button class="project-ov-view-more-button">
                View more
            </button>
        </div>
    </div>
    <hr/>
</div>
