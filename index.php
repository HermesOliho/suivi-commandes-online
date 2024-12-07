<?php
// Activer les en-têtes CORS
header("Access-Control-Allow-Origin: *"); // Permet l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Méthodes autorisées
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // En-têtes autorisés

// Répondre à une requête OPTIONS pour les vérifications de prévol
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Pas de contenu
    exit();
}

require 'clients.php';
require 'produits.php';
require 'commandes.php';
require 'details_commandes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Routes clients
if ($uri === '/api/clients' && $method === 'GET') {
    getAllClients();
} elseif (preg_match('/\/api\/clients\/(\d+)/', $uri, $matches) && $method === 'GET') {
    getClientById($matches[1]);
} elseif ($uri === '/api/clients' && $method === 'POST') {
    createClient();
} elseif (preg_match('/\/api\/clients\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    updateClient($matches[1]);
} elseif (preg_match('/\/api\/clients\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    deleteClient($matches[1]);

    // Routes produits
} elseif ($uri === '/api/produits' && $method === 'GET') {
    getAllProduits();
} elseif (preg_match('/\/api\/produits\/(\d+)/', $uri, $matches) && $method === 'GET') {
    getProduitById($matches[1]);
} elseif ($uri === '/api/produits' && $method === 'POST') {
    createProduit();
} elseif (preg_match('/\/api\/produits\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    updateProduit($matches[1]);
} elseif (preg_match('/\/api\/produits\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    deleteProduit($matches[1]);

    // Routes commandes
} elseif ($uri === '/api/commandes' && $method === 'GET') {
    getAllCommandes();
} elseif (preg_match('/\/api\/commandes\/(\d+)$/', $uri, $matches) && $method === 'GET') {
    getCommandeById($matches[1]);
} elseif (preg_match('/\/api\/commandes\/(\d+)\/details$/', $uri, $matches) && $method === 'GET') {
    getCommandeWithDetails($matches[1]);
} elseif ($uri === '/api/commandes' && $method === 'POST') {
    createCommande();
} elseif (preg_match('/\/api\/commandes\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    updateCommande($matches[1]);
} elseif (preg_match('/\/api\/commandes\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    deleteCommande($matches[1]);

    // Routes paiements
} elseif ($uri === '/api/paiements' && $method === 'GET') {
    getAllPaiements();
} elseif (preg_match('/\/api\/paiements\/(\d+)/', $uri, $matches) && $method === 'GET') {
    getPaiementById($matches[1]);
} elseif ($uri === '/api/paiements' && $method === 'POST') {
    createPaiement();
} elseif (preg_match('/\/api\/paiements\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    updatePaiement($matches[1]);
} elseif (preg_match('/\/api\/paiements\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    deletePaiement($matches[1]);

    // Routes détails des commandes
} elseif ($uri === '/api/details_commandes' && $method === 'GET') {
    getAllDetailsCommandes();
} elseif (preg_match('/\/api\/details_commandes\/commande\/(\d+)/', $uri, $matches) && $method === 'GET') {
    getDetailsByCommandeId($matches[1]);
} elseif ($uri === '/api/details_commandes' && $method === 'POST') {
    createDetailCommande();
} elseif (preg_match('/\/api\/details_commandes\/(\d+)/', $uri, $matches) && $method === 'PUT') {
    updateDetailCommande($matches[1]);
} elseif (preg_match('/\/api\/details_commandes\/(\d+)/', $uri, $matches) && $method === 'DELETE') {
    deleteDetailCommande($matches[1]);


    // Si aucune route ne correspond
} else {
    echo json_encode(["message" => "Route non trouvée", "url" => $uri, "method" => $method]);
}
