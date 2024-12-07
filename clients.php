<?php
require_once 'database.php';
require_once 'utils.php';

// Obtenir tous les clients
function getAllClients() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM clients");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($clients); // Utilise jsonResponse
}

// Obtenir un client par son ID
function getClientById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($client) {
        jsonResponse($client);
    } else {
        jsonResponse(["message" => "Client non trouvé"], 404);
    }
}

// Créer un nouveau client
function createClient() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO clients (nom, email, adresse, telephone) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'], 
        strtolower($data['email']), 
        $data['adresse'], 
        $data['telephone']
    ]);
    jsonResponse(["id" => $pdo->lastInsertId()], 201);
}

// Mettre à jour un client
function updateClient($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE clients SET nom = ?, email = ?, adresse = ?, telephone = ? WHERE id = ?");
    $stmt->execute([$data['nom'], $data['email'], $data['adresse'], $data['telephone'], $id]);
    jsonResponse(["message" => "Client mis à jour avec succès"]);
}

// Supprimer un client
function deleteClient($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    jsonResponse(["message" => "Client supprimé avec succès"]);
}
