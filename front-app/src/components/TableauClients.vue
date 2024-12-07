<template>
    <div class="input-group my-3">
        <input
            type="search"
            v-model="searchQuery"
            id="search"
            class="form-control"
            placeholder="Trouver un client..."
        />
        <button type="button" class="btn btn-primary">Trouver</button>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Adresse e-mail</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Adresse</th>
                <th scope="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(client, index) in clientsVisibles">
                <td>{{ index + 1 }}</td>
                <td>{{ client.nom }}</td>
                <td>{{ client.email }}</td>
                <td>{{ client.telephone }}</td>
                <td>{{ client.adresse }}</td>
                <td>
                    <div class="d-flex justify-content-end gap-2">
                        <button
                            class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#editerClient"
                            @click="
                                () => {
                                    modeEdition = true;
                                    clientAEditer = client;
                                }
                            "
                        >
                            Modifier
                        </button>
                        <button
                            class="btn btn-danger"
                            @click="supprimer(client)"
                        >
                            Supprimer
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="alert alert-warning" v-if="clientsVisibles.length < 1">
        Aucun résultat !
    </div>
    <Modal
        @save="modifier"
        id="editerClient"
        title="Modifier les informations du client"
        size="lg"
    >
        <form action="" @submit.prevent="modifier">
            <TextField v-model="clientAEditer.nom" label="Nom" />
            <TextField v-model="clientAEditer.email" label="Adresse e-mail" />
            <TextField v-model="clientAEditer.telephone" label="Téléphone" />
            <TextField v-model="clientAEditer.adresse" label="Adresse" />
        </form>
    </Modal>
</template>

<script setup lang="ts">
import { computed, defineProps, defineEmits, ref } from "vue";
import Modal from "./ui/Modal.vue";
import TextField from "./ui/TextField.vue";

const searchQuery = ref("");

const clientAEditer = ref({
    adresse: "",
    email: "",
    id: 0,
    nom: "",
    telephone: "",
});
const modeEdition = ref(true);

const props = defineProps<{
    clients: {
        adresse: string;
        date_creation: string;
        email: string;
        id: number;
        nom: string;
        telephone: string;
    }[];
}>();

const emits = defineEmits(["modifierClient", "supprimerClient"]);

const clientsVisibles = computed(() => {
    return props.clients.filter((cl) => {
        const s = searchQuery.value.toLowerCase();
        return (
            cl.nom.toLowerCase().includes(s) ||
            cl.adresse.toLowerCase().includes(s) ||
            cl.email.toLowerCase().includes(s) ||
            cl.telephone.toLowerCase().includes(s)
        );
    });
});

const modifier = () => {
    emits("modifierClient", clientAEditer.value);
};

const supprimer = (client) => {
    if (confirm("Voulez-vous vraiment supprimer ce client ?")) {
        emits("supprimerClient", client);
    }
};
</script>
