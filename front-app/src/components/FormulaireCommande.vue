<template>
    <form id="commandeForm">
        <div class="mb-3">
            <label for="client_id" class="form-label">ID Client</label>
            <input type="text" class="form-control" id="client_id" required />
        </div>
        <div class="mb-3">
            <label for="date_commande" class="form-label"
                >Date de Commande</label
            >
            <input
                type="date"
                class="form-control"
                id="date_commande"
                required
            />
        </div>
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <input type="text" class="form-control" id="statut" required />
        </div>

        <!-- Détails de la commande -->
        <h5>Détails de la Commande</h5>
        <div id="details-list">
            <!-- Contenu des détails de la commande sera inséré ici dynamiquement -->
        </div>
        <div class="d-flex align-items-center justify-content-start gap-3">
            <button
                type="button"
                class="btn btn-secondary"
                onclick="ajouterDetailCommande()"
            >
                Ajouter un Détail
            </button>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</template>
