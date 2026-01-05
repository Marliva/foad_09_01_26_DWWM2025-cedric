<?php

// On récupère tous les vélos
function getAllVelos($pdo)
{
    $sql = "SELECT * FROM velos ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// On récupère un vélo par ID
function getVeloById($pdo, $id)
{
    $sql = "SELECT * FROM velos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// On ajoute un vélo
function addVelo($pdo, $data)
{
    $sql = "INSERT INTO velos (name, price, quantity, description, image_url)
            VALUES (?, ?, ?, ?, ?)"; // Les "?" sont des placeholders qui protègent les données contre les injections SQL d'après ce que j'ai vu pendant les vacances. C'est la première fois que je teste.
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['name'],
        $data['price'],
        $data['quantity'],
        $data['description'],
        $data['image_url']
    ]);
}

// On modifie un vélo
function updateVelo($pdo, $id, $data)
{
    $sql = "UPDATE velos 
            SET name = ?, price = ?, quantity = ?, description = ?, image_url = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['name'],
        $data['price'],
        $data['quantity'],
        $data['description'],
        $data['image_url'],
        $id
    ]);
}

// On supprime un vélo
function deleteVelo($pdo, $id)
{
    $sql = "DELETE FROM velos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}
