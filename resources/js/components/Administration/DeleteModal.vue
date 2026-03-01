<script setup lang="ts">
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { useNotify } from '@/composables/useNotify';
import { router } from '@inertiajs/vue3';
const { notify } = useNotify();

const { visible = true, route, type = 'soft' } = defineProps<{
    visible: boolean;
    route: string,
    type?: 'soft' | 'hard';
}>();
const emit = defineEmits(['close-modal']);

const deleteRecord = () => {
    router.delete(
        route,
        {
            onSuccess: (page) => {
                const flash = page.props.flash;
                if (flash.success) {
                    notify('success', flash.success);
                } else if (flash.error) {
                    notify('error', flash.error);
                } else {
                    return;
                }
                emit('close-modal');
            },
            onError: (errors) => {
                notify('error', errors);
                emit('close-modal');
            },
        },
    );
};
</script>
<template>
    <div>
        <Dialog :visible="visible" modal :closable="false" class="w-full max-w-md">
            <div class="flex flex-col items-center text-center gap-4">
                <div class="flex flex-col items-center gap-4">
                    <div class="text-red-500 bg-red-100 rounded-full w-15 h-15 flex items-center justify-center">
                        <i class="pi pi-trash text-2xl!"></i>
                    </div>
                    <h2 class="text-xl font-bold">Delete Confirmation</h2>
                </div>
                <div class="flex flex-col gap-2">
                    <p v-if="type === 'soft'">Are you sure you want to delete this record? You can restore it later.</p>
                    <p v-else>Are you sure you want to delete this record? You can't restore it later.</p>
                </div>
                <div class="flex items-center gap-4 w-full">
                    <Button label="Cancel" @click="emit('close-modal')" severity="secondary" variant="outlined"
                        class="flex-1" />
                    <Button label="Delete" @click="deleteRecord" severity="danger" class="flex-1" />
                </div>
            </div>
        </Dialog>
    </div>
</template>
<style scoped></style>