<script setup lang="ts">
defineProps<{
    label: string;
    value: string | boolean | number;
}>();
</script>

<template>
    <div>
        <p class="flex items-center gap-2 text-lg text-slate-600">
            <strong class="text-capitalize">{{ label }}</strong>
            <strong>:</strong>

            <template v-if="typeof value === 'string'">
                <span>{{ value }}</span>
            </template>

            <template v-else-if="typeof value === 'number'">
                <div class="flex items-center gap-2 rounded bg-slate-100 px-2 py-0.5 text-sm text-slate-500">
                    <span>{{ value }}</span>
                </div>
            </template>

            <template v-else>
                <div v-if="value" class="flex items-center gap-2 rounded bg-emerald-100 px-2 py-0.5 text-sm text-emerald-500">
                    <i class="pi pi-check-circle text-xs!"></i>
                    <span>TRUE</span>
                </div>
                <div v-else class="flex items-center gap-2 rounded bg-red-100 px-2 py-0.5 text-sm text-red-500">
                    <i class="pi pi-check-circle text-xs!"></i>
                    <span>FALSE</span>
                </div>
            </template>
        </p>
    </div>
</template>
