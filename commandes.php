<?php
require_once 'database.php';
require_once 'utils.php'; // Inclure jsonResponse si elle est dans utils.php

// Obtenir toutes les commandes
function getAllCommandes()
{
    global $pdo;
    $stmt = $pdo->query(
        "SELECT cm.id, cm.statut, cm.total, cm.date_commande, cl.nom, cl.email, cl.telephone, cl.adresse
        FROM commandes cm
        JOIN clients cl ON cm.client_id = cl.id"
    );
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($commandes);
}

// Obtenir une commande par son ID
function getCommandeById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
    $stmt->execute([$id]);
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($commande) {
        jsonResponse($commande);
    } else {
        jsonResponse(["message" => "Commande non trouvée"], 404);
    }
}

function getCommandeWithDetails($id)
{
    global $pdo;

    // Obtenir la commande principale
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
    $stmt->execute([$id]);
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($commande) {
        // Obtenir les détails de la commande
        $stmt = $pdo->prepare("SELECT * FROM details_commandes WHERE commande_id = ?");
        $stmt->execute([$id]);
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $commande['details'] = $details;
        jsonResponse($commande);
    } else {
        jsonResponse(["message" => "Commande non trouvée"], 404);
    }
}


// Créer une nouvelle commande
function createCommande()
{
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    // Insérer la commande principale
    $stmt = $pdo->prepare("INSERT INTO commandes (client_id, date_commande, total) VALUES (?, ?, ?)");
    $stmt->execute([
        $data['client_id'],
        formatDateForSql($data['date_commande']),
        $data['total'],
    ]);
    $commande_id = $pdo->lastInsertId();

    // Insérer les détails de la commande
    foreach ($data['details'] as $detail) {
        $stmt = $pdo->prepare("INSERT INTO details_commandes (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
        $stmt->execute([$commande_id, $detail['produit_id'], $detail['quantite'], $detail['prix']]);
    }

    jsonResponse(["commande_id" => $commande_id, "message" => "Commande et détails ajoutés avec succès"], 201);
}

// Mettre à jour une commande
function updateCommande($id)
{
    global $pdo;
    
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE commandes SET statut = ?, total = ? WHERE id = ?");
    $stmt->execute([$data['statut'],  $data['total'] ?? 'nouveau', $id]);
    // Modifier les détails de la commande
    foreach ($data['details'] as $detail) {
        if (isset($detail['id']) && is_numeric($detail['id'])) {
            $stmt = $pdo->prepare("UPDATE details_commandes SET produit_id = ?, quantite = ?, prix = ? WHERE id = ?");
            $stmt->execute([$detail['produit_id'], $detail['quantite'], $detail['prix'], $detail['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO details_commandes(commande_id, produit_id, quantite, prix) VALUES(?, ?, ?, ?)");
            $stmt->execute([$id, $detail['produit_id'], $detail['quantite'], $detail['prix']]);
        }
        
    }
    jsonResponse(["message" => "Commande mise à jour avec succès"]);
}

// Supprimer une commande
function deleteCommande($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM commandes WHERE id = ?");
    $stmt->execute([$id]);
    jsonResponse(["message" => "Commande supprimée avec succès"]);
}
