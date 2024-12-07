import GestionClients from "@/views/GestionClients.vue";
import GestionCommandes from "@/views/GestionCommandes.vue";
import GestionPaiements from "@/views/GestionPaiements.vue";
import ModifierCommande from "@/views/ModifierCommande.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "commandes",
            component: GestionCommandes,
        },
        {
            path: "/modifier-commande/:id",
            name: "modifier_commande",
            component: ModifierCommande,
            props: true,
        },
        {
            path: "/clients",
            name: "clients",
            component: GestionClients,
        },
        {
            path: "/paiements",
            name: "paiements",
            component: GestionPaiements,
        },
    ],
});

export default router;
