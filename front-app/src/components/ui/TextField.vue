<template>
    <div class="form-group mb-3">
        <label for="id" v-if="label" class="form-label">
            {{ label }}
            <span class="text-danger" v-if="required">*</span>
        </label>
        <div
            :class="{ 'input-group': true, 'is-invalid': error }"
            v-if="prefix || suffix"
        >
            <div class="input-group-text" v-if="prefix">{{ prefix }}</div>
            <input
                :type="type ?? 'text'"
                :name="name"
                :id="id"
                :class="{ 'form-control': true, 'is-invalid': error }"
                v-model="model"
                :required="required"
                :step="step"
                :disabled="disabled"
            />
            <div class="input-group-text" v-if="suffix">{{ suffix }}</div>
        </div>
        <input
            :type="type ?? 'text'"
            :name="name"
            :id="id"
            :class="{ 'form-control': true, 'is-invalid': error }"
            v-model="model"
            :required="required"
            :step="step"
            :disabled="disabled"
            v-else
        />
        <div class="invalid-feedback" v-if="error">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    type?:
        | "text"
        | "email"
        | "tel"
        | "date"
        | "password"
        | "number"
        | "datetime";
    id?: string;
    name?: string;
    label?: string;
    prefix?: string;
    suffix?: string;
    placeholder?: string;
    error?: string;
    required?: boolean;
    step?: number;
    disabled?: boolean;
}>();

const model = defineModel<string | number>({ required: true });
</script>
