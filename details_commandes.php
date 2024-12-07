<?php
require_once 'database.php';
require_once 'utils.php'; // Inclure jsonResponse si elle est dans utils.php

// Obtenir tous les détails de commandes
function getAllDetailsCommandes() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM details_commandes");
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($details);
}

// Obtenir les détails d'une commande spécifique
function getDetailsByCommandeId($commande_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM details_commandes WHERE commande_id = ?");
    $stmt->execute([$commande_id]);
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($details) {
        jsonResponse($details);
    } else {
        jsonResponse(["message" => "Aucun détail trouvé pour cette commande"], 404);
    }
}

// Créer un nouveau détail pour une commande
function createDetailCommande() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO details_commandes (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['commande_id'], $data['produit_id'], $data['quantite'], $data['prix']]);
    jsonResponse(["id" => $pdo->lastInsertId()], 201);
}

// Mettre à jour un détail de commande
function updateDetailCommande($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE details_commandes SET commande_id = ?, produit_id = ?, quantite = ?, prix = ? WHERE id = ?");
    $stmt->execute([$data['commande_id'], $data['produit_id'], $data['quantite'], $data['prix'], $id]);
    jsonResponse(["message" => "Détail de commande mis à jour avec succès"]);
}

// Supprimer un détail de commande
function deleteDetailCommande($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM details_commandes WHERE id = ?");
    $stmt->execute([$id]);
    jsonResponse(["message" => "Détail de commande supprimé avec succès"]);
}
?>
