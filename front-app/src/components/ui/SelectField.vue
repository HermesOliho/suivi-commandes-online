<template>
    <div class="form-group mb-3">
        <label :for="id" class="form-label" v-if="label"
            >{{ label }}
            <span class="text-danger" v-if="required">*</span></label
        >
        <select
            class="form-select"
            :name="name"
            :id="id"
            :selected="selected"
            :required="required"
            v-model="model"
        >
            <option v-for="opt in options" :value="opt.value">
                {{ opt.text }}
            </option>
        </select>
    </div>
</template>

<script setup lang="ts">
const props = defineProps<{
    name?: string;
    id?: string;
    selected?: string | Number;
    label?: string;
    placeholder?: string;
    required?: boolean;
    options: { value: string | number | boolean; text: string }[];
}>();
const model = defineModel<string | number | boolean>({ required: true });
</script>
