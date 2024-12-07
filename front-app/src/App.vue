<script setup>
import { RouterLink, RouterView } from "vue-router";
import NavBar from "./components/NavBar.vue";
</script>

<template>
    <NavBar />
    <main>
        <div class="container-md pt-4">
            <RouterView />
        </div>
    </main>
</template>

<style scoped></style>
