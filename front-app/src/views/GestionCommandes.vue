<template>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des commandes</h1>
        <!-- Modal trigger button -->
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addOrder"
        >
            Ajouter une commande
        </button>
        <!-- Formulaire d'ajout de commande -->
        <EditerCommande
            id="addOrder"
            v-model="nouvelleCommande"
            :clients="clients"
            :produits="produits"
            @save="enregistrerCommande"
        />
    </div>
    <!-- Liste des Commandes -->
    <section id="commande-liste" class="mb-5">
        <h3>Liste des Commandes</h3>
        <TableauCommandes
            :commandes="commandes"
            @on-details="detailsCommande"
            @on-delete="supprimerCommande"
        />
        <!-- Formulaire de modification de commande -->
        <EditerCommande
            id="updateOrder"
            v-model="nouvelleCommande"
            :clients="clients"
            :produits="produits"
            @save="enregistrerCommande"
        />
    </section>
</template>

<script setup>
import { apiBaseUrl } from "@/api/infos";
import EditerCommande from "@/components/EditerCommande.vue";
import TableauCommandes from "@/components/TableauCommandes.vue";
import { onMounted, ref, watch } from "vue";

const nouvelleCommande = ref({
    client_id: 0,
    date_commande: "",
    total: 0,
    details: [],
});

const chargerCommandes = () => {
    // Récupérer les commandes
    fetch(`${apiBaseUrl}/commandes`)
        .then((r) => {
            if (r.ok) {
                return r.json();
            }
        })
        .then((data) => {
            if (data instanceof Array) {
                commandes.value = data;
            }
            // console.log(data);
        });
};

const detailsCommande = (commande) => {
    return new Promise((resolve, reject) => {
        fetch(`${apiBaseUrl}/commandes/${commande.id}/details`)
            .then((r) => {
                if (r.ok) return r.json();
            })
            .then((data) => {
                console.log(data);
                resolve(data);
            })
            .catch((err) => {
                reject(err);
            });
    });
};

const supprimerCommande = (commande) => {
    console.log("Supprimer :", commande);
};

const enregistrerCommande = () => {
    fetch(`${apiBaseUrl}/commandes`, {
        method: "POST",
        body: JSON.stringify(nouvelleCommande.value),
    })
        .then((r) => {
            if (r.ok) return r.json();
        })
        .then((data) => {
            nouvelleCommande.value = {
                client_id: 0,
                date_commande: "",
                total: 0,
                details: [],
            };
            console.log(data);
            chargerCommandes();
        });
};

const commandes = ref([]);
const clients = ref([]);
const produits = ref([]);

onMounted(() => {
    chargerCommandes();
    // Récupérer les clients
    fetch(`${apiBaseUrl}/clients`)
        .then((r) => {
            if (r.ok) {
                return r.json();
            }
        })
        .then((data) => {
            clients.value = data;
        });
    // Récupérer les produits
    fetch(`${apiBaseUrl}/produits`)
        .then((r) => {
            if (r.ok) {
                return r.json();
            }
        })
        .then((data) => {
            produits.value = data;
        });
});

watch(nouvelleCommande.value.details, () => {
    let total = 0;
    nouvelleCommande.value.details.map((p) => {
        total += Number(p.prix);
    });
    nouvelleCommande.value.total = total;
});
</script>
