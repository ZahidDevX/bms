<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import { computed } from 'vue';

const {
    id,
    label,
    helperText = null,
    maxLength = 255,
    errorMessage = null,
    placeholder = null,
    required = true,
    type = 'text',
} = defineProps<{
    id: string;
    label: string;
    helperText?: string | null;
    maxLength?: number;
    errorMessage?: string | null;
    placeholder?: string | null;
    required?: boolean;
    type?: 'text' | 'email' | 'search';
}>();

const model = defineModel<string>();

const inputLength = computed(() => model.value?.length || 0);
</script>
<template>
    <div class="flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <label :for="id">{{ label }} <span v-if="required" class="flex-1 text-red-500">*</span></label>
            <p v-if="maxLength">
                <span>{{ inputLength }}</span>
                <span>/</span>
                <strong>{{ maxLength }}</strong>
            </p>
        </div>
        <InputText :id="id" :type="type" :placeholder="placeholder ? placeholder : ''"  v-model="model" :maxlength="maxLength? maxLength : undefined"/>
        <Message v-if="helperText" variant="simple" severity="secondary">{{ helperText }}</Message>
        <Message variant="simple" severity="error" v-if="errorMessage">{{ errorMessage }}</Message>
    </div>
</template>
<style scoped></style>
