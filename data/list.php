<?php
require_once __DIR__ . '/../data/db.php';

/** @var PDO $pdo */
$stmt = $pdo->query("SELECT * FROM projects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/list.css">
    <title>Projects | Nathan Geers</title>
</head>
<body>
    <h1>Projects</h1>

    <div class="project-list">
        <?php while ($item = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <?php include __DIR__ . '/../includes/project_card.php'; ?>
        <?php endwhile; ?>
    </div>

</body>
</html>