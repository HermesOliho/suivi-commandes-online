<template>
    <h1>Modifier une commande</h1>
    <form action="" v-if="commande.date_commande" @submit.prevent="submit">
        <SelectField
            v-model="commande.statut"
            :options="[
                { value: 'nouveau', text: 'Nouveau' },
                { value: 'en cours', text: 'En cours' },
                { value: 'expédié', text: 'Expédié' },
                { value: 'livré', text: 'Livré' },
                { value: 'annulé', text: 'Annulé' },
            ]"
            label="Statut"
        />
        <TextField
            v-model="commande.total"
            label="Montant total"
            suffix="$"
            disabled
        />
        <!-- Produits -->
        <h3>Produits</h3>
        <div
            class="row"
            v-for="(produit, index) in details"
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
                    suffix="Pcs ou Kg"
                />
            </div>
            <div class="col">
                <TextField
                    v-model="produit.prix"
                    label="Prix"
                    type="number"
                    suffix="$"
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
        <hr />
        <div class="form-group my-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</template>

<script setup>
import { apiBaseUrl } from "@/api/infos";
import SelectField from "@/components/ui/SelectField.vue";
import TextField from "@/components/ui/TextField.vue";
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
    id: String | Number,
});
const router = useRouter();

const commande = ref({
    statut: "nouveau",
    total: 0,
    details: [],
});
const produits = ref([]);
const details = ref(commande.value.details);

const addDetail = () => {
    details.value.push({ produit_id: 0, quantite: 0, prix: 0 });
};

const removeDetail = (produit) => {
    details.value = details.value.filter((p) => !Object.is(p, produit));
};

const submit = () => {
    commande.value.details = details.value;
    fetch(`${apiBaseUrl}/commandes/${commande.value.id}`, {
        method: "PUT",
        body: JSON.stringify(commande.value),
    })
        .then((r) => {
            if (r.ok) return r.json();
        })
        .then((data) => {
            console.log(data);
            router.push({ name: "commandes" });
        })
        .catch((err) => {
            console.error("Erreur : ", err);
        });
};

onMounted(() => {
    if (props.id) {
        fetch(`${apiBaseUrl}/commandes/${props.id}/details`)
            .then((r) => {
                if (r.ok) return r.json();
            })
            .then((data) => {
                if (data.statut && data.date_commande) {
                    console.log(data);
                    commande.value = data;
                    details.value.push(...commande.value.details);
                }
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
    }
});

watch(details.value, () => {
    let total = 0;
    details.value.map((p) => {
        total += Number(p.prix) * Number(p.quantite);
    });
    commande.value.total = total;
});
</script>
