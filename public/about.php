<?php
require_once __DIR__ . '/../data/db.php';

/** @var PDO $pdo */
$stmt = $pdo->query("SELECT * FROM about");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/portfolio-v2/public/assets/css/about.css">

<div class="about-section">
    <h1 class="about-section-title">About</h1>
    <div class="about-wrapper">
        <div class="about-data">
            <div class="about-available">
                <?php if (!empty($about['is_available'])): ?>
                    <span class="about-available-dot"></span>
                    Available for work
                <?php else: ?>
                    <span class="about-available-dot about-available-dot-off"></span>
                    Not currently available
                <?php endif; ?>
            </div>

            <h2 class="about-intro">
                Hi, I'm Nathan. <br/>
                I build websites, apps, and software solutions.
            </h2>

            <p class="about-description">
                Full-stack developer with a passion for structure and clean code.
            </p>

            <div class="about-skills">
                <?php foreach (explode(',', $about['skills']) as $skill): ?>
                    <button class="about-skill-badge"><?= htmlspecialchars(trim($skill)) ?></button>
                <?php endforeach; ?>
            </div>

            <div class="about-buttons">
                <a href="" class="about-view-more">
                    View more <i class="ti ti-arrow-right"></i>
                </a>
                <?php if (!empty($about['github_url'])): ?>
                    <a href="<?= htmlspecialchars($about['github_url']) ?>" class="about-github-button">
                        Github <i class="ti ti-brand-github"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($about['linkedin_url'])): ?>
                    <a href="<?= htmlspecialchars($about['linkedin_url']) ?>" class="about-linkedin-button">
                        LinkedIn <i class="ti ti-brand-linkedin"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($about['cv_url'])): ?>
                    <a href="<?= htmlspecialchars($about['cv_url']) ?>" class="about-resume-button">
                        Resume <i class="ti ti-download"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="about-picture">
            <div class="about-picture-image">

            </div>
            <div class="about-picture-place">

            </div>
            <div class="about-picture-country">
            </div>
        </div>
    </div>
</div>
