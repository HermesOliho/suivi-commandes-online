<?php
require_once 'database.php';
require_once 'utils.php';

// Obtenir tous les produits
function getAllProduits() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM produits");
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($produits);
}

// Obtenir un produit par son ID
function getProduitById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        jsonResponse($produit);
    } else {
        jsonResponse(["message" => "Produit non trouvé"], 404);
    }
}

// Créer un nouveau produit
function createProduit() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['nom'], $data['description'], $data['prix'], $data['stock']]);
    jsonResponse(["id" => $pdo->lastInsertId()], 201);
}

// Mettre à jour un produit
function updateProduit($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ? WHERE id = ?");
    $stmt->execute([$data['nom'], $data['description'], $data['prix'], $data['stock'], $id]);
    jsonResponse(["message" => "Produit mis à jour avec succès"]);
}

// Supprimer un produit
function deleteProduit($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    jsonResponse(["message" => "Produit supprimé avec succès"]);
}
?>
