<?php
require_once __DIR__ . '/../data/db.php';

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit((string)$id)) {
    http_response_code(400);
    die('Invalid project id.');
}

$projects = supabaseRequest(
    'projects?select=*,project_tags(tag_id,tags(id,name,category)),project_media(media_url,media_type)&id=eq.' . urlencode($id)
);

$project = $projects[0] ?? null;

if (!$project) {
    http_response_code(404);
    die('Project not found.');
}

$galleryVideo = null;
$galleryImages = [];

foreach ($project['project_media'] ?? [] as $mediaItem) {
    if (($mediaItem['media_type'] ?? 'image') === 'video') {
        $galleryVideo = $mediaItem;
    } else {
        $galleryImages[] = $mediaItem;
    }
}

$technologyRows = supabaseRequest('tech?select=tech_name,color');

$technologies = [];
foreach ($technologyRows as $technology) {
    $key = strtolower(trim($technology['tech_name']));
    $technologies[$key] = $technology;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($project['name']) ?> | Nathan Geers</title>

    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/project-detail.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<main class="main-content">
    <div class="project-detail-section">

        <a href="/index.php#projects-section" class="project-detail-back">
            <i class="ti ti-arrow-left"></i>
            Back to projects
        </a>

        <div class="project-detail-header">

            <div class="project-detail-meta-row">
                <?php if (!empty($project['category'])): ?>
                    <span class="project-detail-category">
                        <?= htmlspecialchars($project['category']) ?>
                    </span>
                <?php endif; ?>

                <?php if (!empty($project['is_featured'])): ?>
                    <span class="featured-project-tag">FEATURED PROJECT</span>
                <?php endif; ?>

                <?php if (!empty($project['team_type'])): ?>
                    <span class="featured-project-badge">
                        <?= htmlspecialchars($project['team_type']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="project-detail-title"><?= htmlspecialchars($project['name']) ?></h1>

            <?php if (!empty($project['role'])): ?>
                <p class="project-detail-role">
                    Role: <?= htmlspecialchars($project['role']) ?>
                </p>
            <?php endif; ?>

            <div class="project-card-buttons">
                <?php if (!empty($project['github_url'])): ?>
                    <a
                        href="<?= htmlspecialchars($project['github_url']) ?>"
                        class="project-ov-gh-button"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <i class="ti ti-brand-github"></i>
                        Github
                    </a>
                <?php endif; ?>

                <?php if (!empty($project['live_url'])): ?>
                    <a
                        href="<?= htmlspecialchars($project['live_url']) ?>"
                        class="project-ov-view-more-button"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Live demo <i class="ti ti-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="project-detail-hero">

            <div class="project-detail-media-box">
                <img
                    src="<?= htmlspecialchars($project['media_url']) ?>"
                    alt="<?= htmlspecialchars($project['name']) ?>"
                >
            </div>

            <?php if ($galleryVideo !== null): ?>
                <div class="project-detail-media-box project-detail-video-box">
                    <video
                        src="<?= htmlspecialchars($galleryVideo['media_url']) ?>"
                        controls
                        preload="metadata"
                    ></video>
                </div>
            <?php endif; ?>

        </div>

        <?php if (!empty($galleryImages)): ?>
            <div class="project-detail-gallery">
                <?php foreach ($galleryImages as $mediaItem): ?>
                    <div class="project-detail-gallery-item">
                        <img
                            src="<?= htmlspecialchars($mediaItem['media_url']) ?>"
                            alt="<?= htmlspecialchars($project['name']) ?>"
                            loading="lazy"
                        >
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="project-detail-body">

            <div class="project-detail-content">

                <?php if (!empty($project['short_desc'])): ?>
                    <p class="project-detail-lead">
                        <?= nl2br(htmlspecialchars(str_replace('\n', "\n", $project['short_desc']))) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($project['long_desc'])): ?>
                    <div class="project-detail-text">
                        <?= nl2br(htmlspecialchars(str_replace('\n', "\n", $project['long_desc']))) ?>
                    </div>
                <?php endif; ?>

            </div>

            <aside class="project-detail-sidebar">

                <div class="project-detail-tech">
                    <h3 class="filter-group-title">Tech stack</h3>

                    <div class="project-card-techstack">
                        <?php foreach (explode(',', $project['tech_stack']) as $tech): ?>
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
                </div>

                <?php
                    $projectTags = [];
                    foreach ($project['project_tags'] ?? [] as $pt) {
                        if (!empty($pt['tags']['name'])) {
                            $projectTags[] = $pt['tags'];
                        }
                    }
                ?>

                <?php if (!empty($projectTags)): ?>
                    <div class="project-detail-tags">
                        <h3 class="filter-group-title">Tags</h3>

                        <div class="project-card-techstack">
                            <?php foreach ($projectTags as $tag): ?>
                                <span class="project-tech-badge">
                                    <?= htmlspecialchars($tag['name']) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project['project_size']) || !empty($project['project_people']) || !empty($project['project_context'])): ?>
                    <div class="project-detail-facts">
                        <h3 class="filter-group-title">Details</h3>

                        <dl class="project-detail-fact-list">
                            <?php if (!empty($project['project_size'])): ?>
                                <div class="project-detail-fact">
                                    <dt>Size</dt>
                                    <dd><?= htmlspecialchars($project['project_size']) ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($project['project_people'])): ?>
                                <div class="project-detail-fact">
                                    <dt>People</dt>
                                    <dd><?= htmlspecialchars($project['project_people']) ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($project['project_context'])): ?>
                                <div class="project-detail-fact">
                                    <dt>Context</dt>
                                    <dd><?= htmlspecialchars($project['project_context']) ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>
                <?php endif; ?>

            </aside>

        </div>

    </div>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <span class="footer-name">Nathan Geers</span>
        <span class="footer-meta">© <?= date('Y') ?> · Built with love!</span>
        <a href="#top" class="footer-top">
            Back to top
            <i class="ti ti-arrow-up"></i>
        </a>
    </div>
</footer>

</body>
</html>