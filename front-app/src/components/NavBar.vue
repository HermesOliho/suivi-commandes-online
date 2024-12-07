<script setup lang="ts">
import { RouterLink } from "vue-router";
</script>

<template>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Suivi des commandes</a>
            <button
                class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :to="{ name: 'commandes' }"
                        >
                            Commandes
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :to="{ name: 'clients' }">
                            Clients
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :to="{ name: 'paiements' }"
                        >
                            Paiements
                        </RouterLink>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style lang="css" scoped>
.router-link-active {
    font-weight: 700;
}
</style>
