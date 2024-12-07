<template>
    <Modal
        :id="id ?? 'addOrder'"
        title="Ajouter une commande"
        close-text="Annuler"
        size="lg"
        @save="
            () => {
                emits('save');
                formRef?.reset();
            }
        "
    >
        <form
            action=""
            @submit.prevent="
                () => {
                    emits('save');
                    formRef?.reset();
                }
            "
            :ref="formRef"
        >
            <SelectField
                v-model="model.client_id"
                :options="
                    clients.map((c) => ({
                        value: c.id,
                        text: `${c.nom} | e-mail : ${c.email} | tél : ${c.telephone} | Adresse :  ${c.adresse}`,
                    }))
                "
            />
            <TextField
                type="date"
                v-model="model.date_commande"
                label="Date de la commande"
            />
            <TextField v-model="model.total" label="Total" disabled />
            <hr />
            <h6>Produits</h6>
            <div
                class="row"
                v-for="(produit, index) in model.details"
                :key="`detail_${index}`"
            >
                <div class="col">
                    <SelectField
                        v-model="produit.produit_id"
                        :options="
                            produits.map((p) => ({
                                value: p.id,
                                text: `${p.nom} | ${p.prix}$ / Qté : ${p.stock}`,
                            }))
                        "
                        label="Produit"
                    />
                </div>
                <div class="col">
                    <TextField
                        v-model="produit.quantite"
                        label="Quantité"
                        type="number"
                    />
                </div>
                <div class="col">
                    <TextField
                        v-model="produit.prix"
                        label="Prix"
                        type="number"
                    />
                </div>
                <div class="col d-flex align-items-center">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="removeDetail(produit)"
                    >
                        Retirer
                    </button>
                </div>
            </div>
            <hr />
            <button class="btn btn-primary" @click="addDetail" type="button">
                Ajouter un produit
            </button>
        </form>
    </Modal>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Modal from "./ui/Modal.vue";
import SelectField from "./ui/SelectField.vue";
import TextField from "./ui/TextField.vue";
import { defineModel, defineProps } from "vue";

const formRef = ref(null);

const props = defineProps<{
    id: string;
    clients: {
        adresse: string;
        date_creation: string;
        email: string;
        id: number;
        nom: string;
        telephone: string;
    }[];
    produits: {
        description: string;
        id: number;
        nom: string;
        prix: number;
        stock: number;
    }[];
}>();

const model = defineModel<{
    client_id: number;
    date_commande: string;
    total: number;
    details: { produit_id: number; quantite: number; prix: number }[];
}>();

const emits = defineEmits(["save"]);

const addDetail = () => {
    model.value.details.push({ produit_id: 0, quantite: 0, prix: 0 });
};

const removeDetail = (produit) => {
    model.value.details = model.value.details.filter(
        (p) => !Object.is(p, produit)
    );
};
</script>
