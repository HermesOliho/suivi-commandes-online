CREATE DATABASE suivi_commandes;
USE suivi_commandes;

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    adresse VARCHAR(255),
    telephone VARCHAR(20),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    statut ENUM('nouveau', 'en cours', 'expédié', 'livré', 'annulé') DEFAULT 'nouveau',  
    total DECIMAL(10, 2) NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

CREATE TABLE details_commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);

CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    method_paiement VARCHAR(50),  -- ex : carte, PayPal, virement bancaire
    statut ENUM('en attente', 'payé', 'remboursé') DEFAULT 'en attente',  -- en attente, payé, remboursé
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE
);

