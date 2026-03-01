<script setup lang="ts">
import TextInput from '@/components/Administration/TextInput.vue';
import { useNotify } from '@/composables/useNotify';
import roles from '@/wayfinder/routes/roles';
import { useForm } from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { watch } from 'vue';

interface Role {
    id: number;
    name: string;
}

const props = defineProps<{
    visible: boolean;
    role: Role | null;
}>();

const emit = defineEmits(['closeModal']);

const { notify } = useNotify();

const form = useForm({
    name: '',
});

// Watch role change
watch(
    () => props.role,
    (role) => {
        if (role) {
            form.name = role.name;
        }
    },
    { immediate: true }
);

const submitForm = () => {
    if (!props.role) return;

    form.put(roles.update({ role: props.role.id }).url, {
        onSuccess: (page) => {
            emit('closeModal');
            const flash = page.props.flash;

            if (flash.success) {
                notify('success', flash.success);
            } else if (flash.error) {
                notify('error', flash.error);
            }
        },
        onError: (errors) => {
            notify('error', errors);
        },
    });
};
</script>

<template>
    <Dialog :visible="visible" modal header="Edit Role" class="w-full max-w-lg">
        <template #header>
            <div class="flex items-center gap-4">
                <Avatar icon="pi pi-file-edit" class="bg-blue-50! text-blue-800!" size="large" />
                <div class="flex-1">
                    <h1 class="mb-1 text-2xl font-bold">Edit Role</h1>
                    <p class="text-slate-500">Update role information.</p>
                </div>
            </div>
        </template>

        <div class="space-y-2">
            <TextInput
                id="name"
                label="Role Name"
                helper-text="Update Role Name"
                :error-message="form.errors.name"
                v-model="form.name"
            />

            <div class="mt-4 flex items-center justify-end gap-4">
                <Button
                    @click="submitForm"
                    type="button"
                    label="Update"
                    icon="pi pi-save"
                />
            </div>
        </div>

        <template #closebutton>
            <Button
                type="button"
                rounded
                severity="danger"
                icon="pi pi-times"
                @click="emit('closeModal')"
            />
        </template>
    </Dialog>
</template>
