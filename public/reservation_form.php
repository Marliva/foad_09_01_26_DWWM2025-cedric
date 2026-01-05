<?php
require_once '../config/db_connect.php';
require_once '../includes/functions_velos.php';
require_once '../includes/functions_reservation.php';

$velo_id = $_GET['velo_id'] ?? null;
$velo = getVeloById($pdo, $velo_id);
$pricePerDay = $velo['price'];


$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (createReservation($pdo, $velo_id, $start_date, $end_date)) {
        $message = "Réservation effectuée avec succès !";
    } else {
        $message = "Le vélo n'est pas disponible sur cette période.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
</head>

<body>

    <h1>Réserver : <?= htmlspecialchars($velo['name']) ?></h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">

        <p>
            <strong>Prix par jour :</strong>
            <span id="pricePerDay"><?= $pricePerDay ?></span> €
        </p>

        <label>Date de début :</label><br>
        <input type="date" name="start_date" id="start_date" required><br><br>

        <label>Date de fin :</label><br>
        <input type="date" name="end_date" id="end_date" required><br><br>

        <p>
            <strong>Montant total :</strong>
            <span id="totalPrice">0</span> €
        </p>

        <button type="submit" name="envoyer">Réserver</button>
    </form>

    <p><a href="index.php">Retour au catalogue</a></p>

    <!-- Javascript permettant de calculer le prix total, à déplacer dans un fichier à part, plus tard -->
    <script>
        const pricePerDay = <?= $pricePerDay ?>;
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalPriceSpan = document.getElementById('totalPrice');

        function calculateTotal() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && endDate >= startDate) {
                const diffTime = endDate - startDate;
                let days = diffTime / (1000 * 60 * 60 * 24);

                if (days < 1) {
                    days = 1;
                }

                const total = days * pricePerDay;
                totalPriceSpan.textContent = total.toFixed(2);
            }
        }

        startDateInput.addEventListener('change', calculateTotal);
        endDateInput.addEventListener('change', calculateTotal);
    </script>

</body>

</html>