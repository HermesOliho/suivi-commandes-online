<?php
require_once 'database.php';
require_once 'utils.php'; // Inclure jsonResponse si elle est dans utils.php

// Obtenir tous les paiements
function getAllPaiements() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM paiements");
    $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($paiements);
}

// Obtenir un paiement par son ID
function getPaiementById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM paiements WHERE id = ?");
    $stmt->execute([$id]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paiement) {
        jsonResponse($paiement);
    } else {
        jsonResponse(["message" => "Paiement non trouvé"], 404);
    }
}

// Créer un nouveau paiement
function createPaiement() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO paiements (commande_id, date_paiement, montant, mode_paiement) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['commande_id'], $data['date_paiement'], $data['montant'], $data['mode_paiement']]);
    jsonResponse(["id" => $pdo->lastInsertId()], 201);
}

// Mettre à jour un paiement
function updatePaiement($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE paiements SET commande_id = ?, date_paiement = ?, montant = ?, mode_paiement = ? WHERE id = ?");
    $stmt->execute([$data['commande_id'], $data['date_paiement'], $data['montant'], $data['mode_paiement'], $id]);
    jsonResponse(["message" => "Paiement mis à jour avec succès"]);
}

// Supprimer un paiement
function deletePaiement($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM paiements WHERE id = ?");
    $stmt->execute([$id]);
    jsonResponse(["message" => "Paiement supprimé avec succès"]);
}
?>
