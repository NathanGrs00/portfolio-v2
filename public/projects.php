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

// Build option lists for the extra project-level filters
$extraFilters = [
    'project_size'    => ['label' => 'Size',    'options' => []],
    'project_people'  => ['label' => 'People',  'options' => []],
    'project_context' => ['label' => 'Context', 'options' => []],
];

foreach ($projects as $item) {
    foreach ($extraFilters as $field => &$config) {
        $value = $item[$field] ?? null;
        if ($value !== null && $value !== '' && !in_array($value, $config['options'], true)) {
            $config['options'][] = $value;
        }
    }
    unset($config);
}

foreach ($extraFilters as &$config) {
    sort($config['options']);
}
unset($config);
?>

<link rel="stylesheet" href="/assets/css/projects.css">

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

                <?php foreach ($extraFilters as $field => $config): ?>

                    <?php if (!empty($config['options'])): ?>

                        <div class="filter-group">

                            <h3 class="filter-group-title">
                                <?= htmlspecialchars($config['label']) ?>
                            </h3>

                            <div class="filter-options">

                                <?php foreach ($config['options'] as $option): ?>

                                    <label class="filter-option">
                                        <input
                                            type="checkbox"
                                            name="<?= htmlspecialchars($field) ?>"
                                            value="<?= htmlspecialchars($option) ?>"
                                        >

                                        <span>
                                            <?= htmlspecialchars($option) ?>
                                        </span>
                                    </label>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

                <hr class="filter-menu-divider">

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
                data-project-size="<?= htmlspecialchars($item['project_size'] ?? '') ?>"
                data-project-people="<?= htmlspecialchars($item['project_people'] ?? '') ?>"
                data-project-context="<?= htmlspecialchars($item['project_context'] ?? '') ?>"
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