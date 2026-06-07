<?php
?>
<div class="project-card">
    <img src="<?= htmlspecialchars($item['image']) ?>"
         alt="<?= htmlspecialchars($item['title']) ?>">

    <h2><?= htmlspecialchars($item['title']) ?></h2>

<p><?= htmlspecialchars($item['description']) ?></p>
</div>