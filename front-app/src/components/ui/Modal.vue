<template>
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div
        class="modal fade"
        :id="id"
        tabindex="-1"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        role="dialog"
        aria-labelledby="modalTitleId"
        aria-hidden="true"
    >
        <div
            :class="`modal-dialog modal-dialog-scrollable modal-dialog-centered modal-${
                size ?? 'sm'
            }`"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">{{ title }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        @click="emits('cancel')"
                    >
                        {{ closeText ?? "Fermer" }}
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        @click="emits('save')"
                    >
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Place to the bottom of scripts -->
    <!-- <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options
        );
    </script> -->
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    title: String,
    closeText: String,
    id: String,
    size: String,
});

const emits = defineEmits(["save", "cancel"]);
</script>
