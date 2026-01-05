<?php
require_once '../config/db_connect.php';
require_once '../includes/functions_velos.php';

$velos = getAllVelos($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RESAVELO - Location de vélos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Location de vélos</h1>

<div class="velos-container">
    <?php foreach ($velos as $velo): ?>
        <div class="velo-card">
            <h2><?= htmlspecialchars($velo['name']) ?></h2>

            <?php if (!empty($velo['image_url'])): ?>
                <img src="../assets/imgs/<?= htmlspecialchars($velo['image_url']) ?>" alt="">
            <?php endif; ?>

            <p><?= htmlspecialchars($velo['description']) ?></p>
            <p><strong><?= $velo['price'] ?> € / jour</strong></p>
            <p>Disponibles : <?= $velo['quantity'] ?></p>

            <a href="reservation_form.php?velo_id=<?= $velo['id'] ?>">
                Réserver ce vélo
            </a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
