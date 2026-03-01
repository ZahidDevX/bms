<script setup lang="ts">
import TextInput from '@/components/Administration/TextInput.vue';
import { useNotify } from '@/composables/useNotify';
import roles from '@/wayfinder/routes/roles';
import { useForm } from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

const { notify } = useNotify();

// Modal
const { visible = true } = defineProps<{
    visible: boolean;
}>();

const emit = defineEmits(['closeModal']);

// Handle Form Submit
const form = useForm({
    name: '',
});

const submitForm = (assignPermission = false) => {
    form.transform((data) => {
        return {
            ...data,
            assignPermission,
        };
    }).submit(roles.store(), {
        onSuccess: (page) => {
            form.reset();
            emit('closeModal');
            const flash = page.props.flash;
            if (flash.success) {
                notify('success', flash.success);
            } else if (flash.error) {
                notify('error', flash.error);
            } else {
                return;
            }
        },
        onError: (errors) => {
            form.reset();
            notify('error', errors);
        },
    });
};
</script>

<template>
    <Dialog :visible="visible" modal header="Create Role" class="w-full max-w-lg">
        <template #header>
            <div class="flex items-center gap-4">
                <Avatar icon="pi pi-key" class="bg-emerald-50! text-emerald-800!" size="large" />
                <div class="flex-1">
                    <h1 class="mb-1 text-2xl font-bold">Create Role</h1>
                    <p class="text-slate-500">Create Role For manage users permissions.</p>
                </div>
            </div>
        </template>
        <div class="space-y-2">
            <TextInput id="name" label="Role Name" helper-text="Enter Role Name" :error-message="form.errors.name" v-model="form.name" />
            <div class="mt-4 flex items-center justify-end gap-4">
                <Button @click="submitForm(true)" type="button" severity="contrast" label="Save & Assign Permissions" icon="pi pi-save"></Button>
                <Button @click="submitForm()" type="button" label="Save" icon="pi pi-save"></Button>
            </div>
        </div>
        <template #closebutton>
            <Button type="button" rounded severity="danger" icon="pi pi-times" @click="emit('closeModal')"></Button>
        </template>
    </Dialog>
</template>

<style scoped></style>
