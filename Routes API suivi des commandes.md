

| Route                   | Méthode HTTP | Fonction                       | Description                             |
|-------------------------|--------------|--------------------------------|-----------------------------------------|
| `/api/clients`          | GET          | `getAllClients()`              | Récupère tous les clients               |
| `/api/clients/{id}`     | GET          | `getClientById($id)`           | Récupère un client par son ID           |
| `/api/clients`          | POST         | `createClient()`               | Crée un nouveau client                  |
| `/api/clients/{id}`     | PUT          | `updateClient($id)`            | Met à jour les informations d'un client |
| `/api/clients/{id}`     | DELETE       | `deleteClient($id)`            | Supprime un client par son ID           |

#### 2. **Produits**

| Route                    | Méthode HTTP | Fonction                        | Description                             |
|--------------------------|--------------|---------------------------------|-----------------------------------------|
| `/api/produits`          | GET          | `getAllProduits()`             | Récupère tous les produits              |
| `/api/produits/{id}`     | GET          | `getProduitById($id)`          | Récupère un produit par son ID          |
| `/api/produits`          | POST         | `createProduit()`              | Crée un nouveau produit                 |
| `/api/produits/{id}`     | PUT          | `updateProduit($id)`           | Met à jour un produit                   |
| `/api/produits/{id}`     | DELETE       | `deleteProduit($id)`           | Supprime un produit par son ID          |

#### 3. **Commandes**

| Route                      | Méthode HTTP | Fonction                          | Description                                      |
|----------------------------|--------------|-----------------------------------|--------------------------------------------------|
| `/api/commandes`           | GET          | `getAllCommandes()`               | Récupère toutes les commandes                    |
| `/api/commandes/{id}`      | GET          | `getCommandeById($id)`            | Récupère une commande par son ID                 |
| `/api/commandes`           | POST         | `createCommande()`                | Crée une nouvelle commande                       |
| `/api/commandes/{id}`      | PUT          | `updateCommande($id)`             | Met à jour le statut d'une commande              |
| `/api/commandes/{id}`      | DELETE       | `deleteCommande($id)`             | Supprime une commande par son ID                 |

#### 4. **Paiements**

| Route                       | Méthode HTTP | Fonction                           | Description                                         |
|-----------------------------|--------------|------------------------------------|-----------------------------------------------------|
| `/api/paiements`            | GET          | `getAllPaiements()`               | Récupère tous les paiements                         |
| `/api/paiements/{id}`       | GET          | `getPaiementById($id)`            | Récupère un paiement par son ID                     |
| `/api/paiements`            | POST         | `createPaiement()`                | Enregistre un nouveau paiement                      |
| `/api/paiements/{id}`       | PUT          | `updatePaiement($id)`             | Met à jour le statut ou les informations de paiement |
| `/api/paiements/{id}`       | DELETE       | `deletePaiement($id)`             | Supprime un paiement par son ID                     |


