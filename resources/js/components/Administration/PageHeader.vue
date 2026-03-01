<script setup lang="ts">
import Avatar from 'primevue/avatar';
const {
    title,
    description,
    icon = 'pi pi-hashtag',
} = defineProps<{
    title: string;
    description?: string;
    icon?: string;
}>();
</script>

<template>
    <header class="mb-6 rounded-md bg-white p-4">
        <div class="grid items-center gap-4 md:grid-cols-2">
            <div class="flex items-center gap-4">
                <Avatar v-if="icon" :icon="icon" class="bg-emerald-50! text-emerald-800!" size="xlarge" />
                <div class="flex-1">
                    <h1 class="mb-1 text-2xl font-bold">{{ title }}</h1>
                    <p v-if="description" class="text-slate-500">{{ description }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-end gap-4">
                <slot name="buttons"></slot>
            </div>
        </div>
    </header>
</template>
