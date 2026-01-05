<?php

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// On vérifie si un vélo est disponible sur une période donnée
function checkAvailability($pdo, $velo_id, $start_date, $end_date) {
    // On récupère la quantité totale du vélo
    $sqlVelo = "SELECT quantity FROM velos WHERE id = ?";
    $stmtVelo = $pdo->prepare($sqlVelo);
    $stmtVelo->execute([$velo_id]);
    $velo = $stmtVelo->fetch();

    if (!$velo) {
        return false;
    }

    // On compte les réservations qui se chevauchent
    $sql = "
        SELECT COUNT(*) AS total
        FROM reservations
        WHERE velo_id = ?
        AND status IN ('en_attente', 'validee')
        AND (
            start_date <= ?
            AND end_date >= ?
        )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$velo_id, $end_date, $start_date]);
    $result = $stmt->fetch();

    return $result['total'] < $velo['quantity'];
}
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// On créé une nouvelle réservation
function createReservation($pdo, $velo_id, $start_date, $end_date) {
    // Vérification disponibilité
    if (!checkAvailability($pdo, $velo_id, $start_date, $end_date)) {
        return false;
    }

    // Récupérer le prix journalier
    $sql = "SELECT price FROM velos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$velo_id]);
    $velo = $stmt->fetch();

    if (!$velo) {
        return false;
    }

    // Calcul du prix total
    require_once __DIR__ . '/functions_calculation.php';
    $total_price = calculatePrice($velo['price'], $start_date, $end_date);

    // Insertion réservation
    $sql = "
        INSERT INTO reservations (velo_id, start_date, end_date, total_price)
        VALUES (?, ?, ?, ?)
    ";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $velo_id,
        $start_date,
        $end_date,
        $total_price
    ]);
}
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// On récupère toutes les réservations
function getAllReservations($pdo) {
    $sql = "
        SELECT r.*, v.name AS velo_name
        FROM reservations r
        JOIN velos v ON r.velo_id = v.id
        ORDER BY r.created_at DESC
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// On modifie le statut d'une réservation
function updateReservationStatus($pdo, $id, $status){
    $sql = "UPDATE reservations SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$status, $id]);
}
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// On annule une réservation (on la supprime)
function cancelReservation($pdo, $id) {
    return updateReservationStatus($pdo, $id, 'annulee');
}
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------