// Base URL de l'API
const apiBaseUrl = "http://localhost:3000/api";

// Fonction pour charger et afficher la liste des commandes
async function chargerCommandes() {
    try {
        const response = await fetch(`${apiBaseUrl}/commandes`);
        const commandes = await response.json();

        // Vider le tableau existant
        document.getElementById("commande-table").innerHTML = "";

        // Remplir le tableau avec les commandes
        commandes.forEach((commande) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${commande.id}</td>
                <td>${commande.client_id}</td>
                <td>${commande.date_commande}</td>
                <td>${commande.statut}</td>
                <td class="text-end">
                    <button class="btn btn-primary btn-sm" onclick="afficherDetails(${commande.id})">Détails</button>
                    <button class="btn btn-secondary btn-sm" onclick="modifierCommande(${commande.id})">Modifier</button>
                    <button class="btn btn-danger btn-sm" onclick="supprimerCommande(${commande.id})">Supprimer</button>
                </td>
            `;
            document.getElementById("commande-table").appendChild(row);
        });
    } catch (error) {
        console.error("Erreur lors du chargement des commandes:", error);
    }
}

// Fonction pour ajouter ou modifier une commande
async function soumettreCommande(event) {
    event.preventDefault();

    const client_id = document.getElementById("client_id").value;
    const date_commande = document.getElementById("date_commande").value;
    const statut = document.getElementById("statut").value;

    // Préparer les détails de la commande
    const details = Array.from(document.querySelectorAll(".detail-item")).map(
        (detail) => ({
            produit: detail.querySelector(".produit").value,
            quantite: detail.querySelector(".quantite").value,
            prix_unitaire: detail.querySelector(".prix_unitaire").value,
        })
    );

    const data = {
        client_id,
        date_commande,
        statut,
        details,
    };

    try {
        let response;
        if (commandeEnCoursId) {
            // Modification d'une commande existante
            response = await fetch(
                `${apiBaseUrl}/commandes/${commandeEnCoursId}`,
                {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data),
                }
            );
        } else {
            // Ajout d'une nouvelle commande
            response = await fetch(`${apiBaseUrl}/commandes`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
            });
        }

        if (response.ok) {
            chargerCommandes();
            document.getElementById("commandeForm").reset();
            commandeEnCoursId = null;
        }
    } catch (error) {
        console.error("Erreur lors de la soumission de la commande:", error);
    }
}

// Fonction pour afficher les détails d'une commande
async function afficherDetails(id) {
    try {
        const response = await fetch(`${apiBaseUrl}/commandes/${id}/details`);
        const commande = await response.json();
        console.log(commande);

        document.getElementById("commande-id").textContent = commande.id;
        document.getElementById("commande-client-id").textContent =
            commande.client_id;
        document.getElementById("commande-date").textContent =
            commande.date_commande;
        document.getElementById("commande-statut").textContent =
            commande.statut;

        // Afficher les articles de la commande
        const detailsTable = document.getElementById("details-table");
        detailsTable.innerHTML = "";
        commande.details.forEach((detail) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${detail.produit}</td>
                <td>${detail.quantite}</td>
                <td>${detail.prix_unitaire}</td>
            `;
            detailsTable.appendChild(row);
        });

        // Afficher la section des détails
        document.getElementById("commande-details").style.display = "block";
    } catch (error) {
        console.error(
            "Erreur lors de l'affichage des détails de la commande:",
            error
        );
    }
}

// Fonction pour fermer la vue des détails
function fermerDetails() {
    document.getElementById("commande-details").style.display = "none";
}

// Fonction pour supprimer une commande
async function supprimerCommande(id) {
    try {
        const response = await fetch(`${apiBaseUrl}/commandes/${id}`, {
            method: "DELETE",
        });

        if (response.ok) {
            chargerCommandes();
        }
    } catch (error) {
        console.error("Erreur lors de la suppression de la commande:", error);
    }
}

// Fonction pour ajouter un nouvel article de commande
function ajouterDetailCommande() {
    const detailDiv = document.createElement("div");
    detailDiv.classList.add("detail-item", "mb-2");
    detailDiv.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control produit" placeholder="Produit" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control quantite" placeholder="Quantité" required>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control prix_unitaire" placeholder="Prix Unitaire" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.parentElement.remove()">Supprimer</button>
            </div>
        </div>
    `;
    document.getElementById("details-list").appendChild(detailDiv);
}

// Charger les clients
async function chargerClients() {
    const response = await fetch(`${apiBaseUrl}/clients`);
    const clients = await response.json();
    document.getElementById("client-table").innerHTML = "";
    clients.forEach((client) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${client.id}</td>
            <td>${client.nom}</td>
            <td>${client.email}</td>
            <td>${client.telephone}</td>
            <td>${client.adresse}</td>
            <td>
                <button class="btn btn-secondary btn-sm" onclick="modifierClient(${client.id})">Modifier</button>
                <button class="btn btn-danger btn-sm" onclick="supprimerClient(${client.id})">Supprimer</button>
            </td>
        `;
        document.getElementById("client-table").appendChild(row);
    });
}

// Charger les paiements
async function chargerPaiements() {
    const response = await fetch(`${apiBaseUrl}/paiements`);
    const paiements = await response.json();
    document.getElementById("paiement-table").innerHTML = "";
    paiements.forEach((paiement) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${paiement.id}</td>
            <td>${paiement.commande_id}</td>
            <td>${paiement.montant}</td>
            <td>${paiement.date_paiement}</td>
            <td>${paiement.methode}</td>
            <td>${paiement.statut}</td>
            <td>
                <button class="btn btn-secondary btn-sm" onclick="modifierPaiement(${paiement.id})">Modifier</button>
                <button class="btn btn-danger btn-sm" onclick="supprimerPaiement(${paiement.id})">Supprimer</button>
            </td>
        `;
        document.getElementById("paiement-table").appendChild(row);
    });
}

// Ajouter ou modifier un client
async function soumettreClient(event) {
    event.preventDefault();
    const data = {
        nom: document.getElementById("nom").value,
        email: document.getElementById("email").value,
        telephone: document.getElementById("telephone").value,
        adresse: document.getElementById("adresse").value,
    };

    let response;
    if (clientEnCoursId) {
        response = await fetch(`${apiBaseUrl}/clients/${clientEnCoursId}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        });
    } else {
        response = await fetch(`${apiBaseUrl}/clients`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        });
    }
    if (response.ok) chargerClients();
    document.getElementById("clientForm").reset();
    clientEnCoursId = null;
}

// Ajouter un paiement
async function soumettrePaiement(event) {
    event.preventDefault();
    const data = {
        commande_id: document.getElementById("commande_id").value,
        montant: document.getElementById("montant").value,
        date_paiement: document.getElementById("date_paiement").value,
        methode: document.getElementById("methode").value,
        statut: document.getElementById("statut").value,
    };

    const response = await fetch(`${apiBaseUrl}/paiements`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    });

    if (response.ok) chargerPaiements();
    document.getElementById("paiementForm").reset();
}

/**
 * @type {NodeList<HTMLElement>}
 */
const sections = document.querySelectorAll("section");

// La fonction pour afficher les sections
/**
 *
 * @param {Array<string>} ids Les ids de section qui peuvent être affichées
 */
const afficherSections = (ids) => {
    for (const section of sections) {
        let include = false;
        for (const id of ids) {
            if (section.id.includes(id)) {
                include = true;
                break;
            }
        }
        if (include) {
            section.style.display = "block";
        } else {
            section.style.display = "none";
        }
    }
};

// Initialisation
let commandeEnCoursId = null;
let clientEnCoursId = null;
let paiementEnCoursId = null;
document
    .getElementById("commandeForm")
    .addEventListener("submit", soumettreCommande);
chargerCommandes();
document
    .getElementById("clientForm")
    .addEventListener("submit", soumettreClient);
document
    .getElementById("paiementForm")
    .addEventListener("submit", soumettrePaiement);
// Charger les clients et paiements au chargement de la page
chargerCommandes(apiBaseUrl);
chargerClients(apiBaseUrl);
chargerPaiements(apiBaseUrl);

afficherSections(["commande"]);

const navLinks = document.querySelectorAll("a.nav-link");

navLinks.forEach((link) => {
    link.addEventListener("click", () => {
        navLinks.forEach((l) => l.classList.remove("active"));
        link.classList.add("active");
        if (link.hasAttribute("data-show")) {
            afficherSections(link.getAttribute("data-show").split("|"));
        }
    });
});
