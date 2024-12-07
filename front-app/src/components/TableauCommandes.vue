<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Client</th>
                <th scope="col">Adresse</th>
                <th scope="col">Date</th>
                <th scope="col" class="text-end">Total</th>
                <th scope="col">Statut</th>
                <th scope="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="commande in commandes"
                :key="`row_${commande.id}_${commande.adresse}`"
            >
                <td>{{ commande.id }}</td>
                <!-- Infos du client -->
                <td>
                    <strong>{{ commande.nom }}</strong
                    ><br />
                    <span class="text-secondary">
                        E-mail : {{ commande.email }}<br />
                        Tél :
                        <span class="fw-bold">
                            {{ commande.telephone }}
                        </span>
                    </span>
                </td>
                <td>{{ commande.adresse }}</td>
                <td>Le {{ formatDate(commande.date_commande) }}</td>
                <td class="text-end">{{ commande.total }} $</td>
                <td>
                    <div
                        :class="{
                            badge: true,
                            'bg-primary': commande.statut === 'nouveau',
                            'bg-info': commande.statut === 'en cours',
                            'bg-secondary': commande.statut === 'expédié',
                            'bg-success': commande.statut === 'livré',
                            'bg-danger': commande.statut === 'annulé',
                        }"
                    >
                        {{ commande.statut }}
                    </div>
                </td>
                <!-- Actions -->
                <td class="text-end">
                    <div
                        class="d-flex justify-content-end align-items-center gap-2"
                    >
                        <button
                            class="btn btn-primary"
                            @click="emits('onDetails', commande)"
                        >
                            Détails
                        </button>
                        <button
                            class="btn btn-warning"
                            @click="
                                () => {
                                    router.push({
                                        name: 'modifier_commande',
                                        params: { id: commande.id },
                                    });
                                }
                            "
                        >
                            Modifier
                        </button>
                        <button
                            class="btn btn-danger"
                            @click="handleDelete(commande)"
                        >
                            Supprimer
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { formatDate } from "@/utils/sting";
import { ref } from "vue";
import { defineProps } from "vue";
import { useRouter } from "vue-router";
/*
Format des données récupérées de la base des données
adresse: "7343 Hayden Rapid"
date_commande: "2024-10-27 00:00:00"
email: "Douglas_Block@gmail.com"
id: 1
nom: "Ron Krajcik"
statut: "nouveau"
telephone: "523.827.9221 x632"
total: "682.00"
*/

const router = useRouter();
const props = defineProps({
    commandes: Array,
});

const emits = defineEmits(["onDetails", "onModify", "OnDelete"]);

const handleDelete = (commande) => {
    if (confirm("Voulez-vous vraiment supprimer cette commande ?")) {
        emits("OnDelete", commande);
    }
};
</script>
