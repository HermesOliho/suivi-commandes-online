<template>
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestion des clients</h1>
        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#ajouterClient"
        >
            Ajouter un client
        </button>
    </div>
    <TableauClients
        :clients="clients"
        v-if="clients"
        @modifier-client="modifierClient"
        @supprimer-client="supprimerClient"
    />
    <div class="alert alert-info" v-else>Aucun client pour le moment !</div>
    <Modal
        @save="ajouterClient(nouveauClient)"
        id="ajouterClient"
        title="Ajouter un client"
        size="lg"
    >
        <form action="" @submit.prevent="ajouterClient(nouveauClient)">
            <TextField v-model="nouveauClient.nom" label="Nom" />
            <TextField v-model="nouveauClient.email" label="Adresse e-mail" />
            <TextField v-model="nouveauClient.telephone" label="Téléphone" />
            <TextField v-model="nouveauClient.adresse" label="Adresse" />
        </form>
    </Modal>
</template>

<script setup lang="ts">
import { apiBaseUrl } from "@/api/infos";
import TableauClients from "@/components/TableauClients.vue";
import Modal from "@/components/ui/Modal.vue";
import TextField from "@/components/ui/TextField.vue";
import { onMounted, ref } from "vue";

const clients = ref([]);

const nouveauClient = ref({
    adresse: "",
    email: "",
    id: 0,
    nom: "",
    telephone: "",
});

const chargerClients = () => {
    fetch(`${apiBaseUrl}/clients`)
        .then((r) => {
            if (r.ok) return r.json();
        })
        .then((data) => {
            if (data instanceof Array) {
                clients.value = data;
            }
        });
};

const ajouterClient = (client) => {
    fetch(`${apiBaseUrl}/clients`, {
        method: "POST",
        body: JSON.stringify(client),
    })
        .then((r) => {
            if (r.ok) return r.text();
        })
        .then((data) => {
            console.log(data);
            chargerClients();
        });
};

const modifierClient = (client) => {
    fetch(`${apiBaseUrl}/clients/${client.id}`, {
        method: "PUT",
        body: JSON.stringify(client),
    })
        .then((r) => {
            if (r.ok) return r.json();
        })
        .then((data) => {
            console.log(data);
            chargerClients();
        });
};

const supprimerClient = (client) => {
    fetch(`${apiBaseUrl}/clients/${client.id}`, { method: "DELETE" })
        .then((r) => {
            if (r.ok) return r.json();
        })
        .then((data) => {
            console.log(data);
            chargerClients();
        });
};

onMounted(() => {
    chargerClients();
});
</script>
