<?php
require_once __DIR__ . '/../data/db.php';

$projects = supabaseRequest(
    'projects?select=*,project_tags(tag_id,tags(id,name,category))&order=id.desc'
);

// Always put the featured project first
usort($projects, function ($a, $b) {
    return (int)($b['is_featured'] ?? false) <=> (int)($a['is_featured'] ?? false);
});

$tags = supabaseRequest(
    'tags?select=id,name,category&order=category.asc'
);
?>

<link rel="stylesheet" href="/portfolio-v2/public/assets/css/projects.css">

<div class="projects-section" id="projects-section">
    <hr id="about-end-hr">
    <div class="projects-header">
        <h2>Projects</h2>
    
        <div class="project-filter">
            <button class="project-filter-button" id="project-filter-button" type="button">
                <span>Filter</span>
                <span class="filter-icon">☰</span>
            </button>

            <div class="project-filter-menu" id="project-filter-menu">

                <?php
                $tagGroups = [];

                foreach ($tags as $tag) {
                    $category = $tag['category'] ?? 'Other';
                    $tagGroups[$category][] = $tag;
                }
                ?>

                <?php foreach ($tagGroups as $category => $categoryTags): ?>

                    <div class="filter-group">

                        <h3 class="filter-group-title">
                            <?= htmlspecialchars($category) ?>
                        </h3>

                        <div class="filter-options">

                            <?php foreach ($categoryTags as $tag): ?>

                                <label class="filter-option">
                                    <input
                                        type="checkbox"
                                        name="project-tag"
                                        value="<?= htmlspecialchars($tag['id']) ?>"
                                    >

                                    <span>
                                        <?= htmlspecialchars($tag['name']) ?>
                                    </span>
                                </label>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="project-list">

       <?php foreach ($projects as $index => $item): ?>

            <?php
            $projectTagIds = [];

            foreach ($item['project_tags'] ?? [] as $projectTag) {
                if (isset($projectTag['tag_id'])) {
                    $projectTagIds[] = $projectTag['tag_id'];
                }
            }

            $projectTagIds = array_unique($projectTagIds);
            ?>

            <div
                class="project-filter-item"
                data-project-tags="<?= htmlspecialchars(implode(',', $projectTagIds)) ?>"
            >

                <?php if ($item['is_featured'] == true): ?>
                    <?php include __DIR__ . '/../includes/project_card_featured.php'; ?>
                <?php else: ?>
                    <?php include __DIR__ . '/../includes/project_card.php'; ?>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>
</div>