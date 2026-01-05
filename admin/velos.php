<?php
require_once '../config/db_connect.php';
require_once '../includes/functions_velos.php';

$velos = getAllVelos($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Vélos</title>
</head>
<body>

<h1>Gestion des vélos</h1>

<p><a href="velo_form.php">Ajouter un vélo</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>Nom</th>
        <th>Prix / jour</th>
        <th>Quantité</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($velos as $velo): ?>
        <tr>
            <td><?= htmlspecialchars($velo['name']) ?></td>
            <td><?= $velo['price'] ?> €</td>
            <td><?= $velo['quantity'] ?></td>
            <td>
                <a href="velo_form.php?id=<?= $velo['id'] ?>">Modifier</a> |
                <a href="velos.php?delete=<?= $velo['id'] ?>"
                   onclick="return confirm('Supprimer ce vélo ?')">
                   Supprimer
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
