<?php
?>
<div class="project-card">
    <h2 class="project-card__title">
        <?= htmlspecialchars($item['name']) ?>
    </h2>
    <p>
        <?= htmlspecialchars($item['short_desc']) ?>
    </p>
    <button id="project-ov-gh-button">
        GH
    </button>
    <button>
        View more
    </button>
    <hr/>
</div>
