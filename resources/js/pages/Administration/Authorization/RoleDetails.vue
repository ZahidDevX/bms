<script setup lang="ts">
import InfoLine from '@/components/Administration/InfoLine.vue';
import PageHeader from '@/components/Administration/PageHeader.vue';
import { useNotify } from '@/composables/useNotify';
import AppLayout from '@/layouts/AppLayout.vue';
import roles from '@/wayfinder/routes/roles';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import { computed } from 'vue';

const { notify } = useNotify();

// Props
interface Role {
    id: number;
    name: string;
    order: number;
    status: boolean;
    isSystem: boolean;
    isAssignable: boolean;
    permissions?: Permission[];
}

interface Permission {
    id: number;
    name: string;
    groupName: string;
}

const props = defineProps<{
    role: { data: Role; };
    permissionGroups: Record<string, Permission[]>;
}>();

// Initialize form with current role permissions
const form = useForm({
    permissions: props.role.data.permissions?.map(p => p.id) || []
});

// Helper to get all permission IDs
const allPermissionIds = computed(() => {
    const ids: number[] = [];
    Object.values(props.permissionGroups).forEach(group => {
        group.forEach(permission => {
            ids.push(permission.id);
        });
    });
    return ids;
});

// Helper to get permission IDs for a specific group
const getGroupPermissionIds = (groupName: string): number[] => {
    return props.permissionGroups[groupName]?.map(p => p.id) || [];
};

// Check if a permission is selected
const isPermissionSelected = (permissionId: number): boolean => {
    return form.permissions.includes(permissionId);
};

// Check if all permissions in a group are selected
const isGroupSelected = (groupName: string): boolean => {
    const groupIds = getGroupPermissionIds(groupName);
    return groupIds.length > 0 && groupIds.every(id => form.permissions.includes(id));
};

// Check if all permissions are selected
const isAllSelected = computed(() => {
    return allPermissionIds.value.length > 0 &&
        allPermissionIds.value.every(id => form.permissions.includes(id));
});

// Toggle individual permission
const togglePermission = (permissionId: number) => {
    const index = form.permissions.indexOf(permissionId);
    if (index > -1) {
        form.permissions.splice(index, 1);
    } else {
        form.permissions.push(permissionId);
    }
};

// Toggle all permissions in a group
const toggleGroup = (groupName: string) => {
    const groupIds = getGroupPermissionIds(groupName);
    const allSelected = isGroupSelected(groupName);

    if (allSelected) {
        // Remove all group permissions
        form.permissions = form.permissions.filter(id => !groupIds.includes(id));
    } else {
        // Add all group permissions
        groupIds.forEach(id => {
            if (!form.permissions.includes(id)) {
                form.permissions.push(id);
            }
        });
    }
};

// Toggle all permissions
const toggleAll = () => {
    if (isAllSelected.value) {
        form.permissions = [];
    } else {
        form.permissions = [...allPermissionIds.value];
    }
};

// Submit form
const savePermissions = () => {
    form.submit(roles.assignPermissions({ role: props.role.data.id }), {
        preserveScroll: true,
        onSuccess: (page) => {
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
            notify('error', errors);
        },
    });
};

</script>

<template>

    <Head :title="`Role Details - ${role.data.name}`" />

    <AppLayout>
        <PageHeader :title="`Role: ${role.data.name}`"
            description="Detailed overview of role configurations and permissions" icon="pi pi-shield">
            <template #buttons>
                <Button :as="Link" :href="roles.index()" label="Back to List" icon="pi pi-arrow-left" variant="text" />
                <!-- <Button :as="Link" :href="roles.({ role: role.data.id })" label="Edit Role" icon="pi pi-pencil" /> -->
            </template>
        </PageHeader>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <section class="space-y-6 lg:col-span-1">
                <div class="rounded-md border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 flex items-center gap-2 text-lg font-bold">
                        <i class="pi pi-info-circle text-primary"></i>
                        General Information
                    </h3>
                    <div class="space-y-4">
                        <InfoLine label="Display Name" :value="role.data.name" />
                        <InfoLine label="Sort Order" :value="role.data.order" />
                        <InfoLine label="Status" :value="role.data.status" />
                    </div>
                </div>

                <div class="rounded-md border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 flex items-center gap-2 text-lg font-bold">
                        <i class="pi pi-cog text-primary"></i>
                        System Settings
                    </h3>
                    <div class="space-y-4">
                        <InfoLine label="System Reserved" :value="role.data.isSystem" />
                        <InfoLine label="Assignable to Users" :value="role.data.isAssignable" />
                    </div>
                </div>
            </section>

            <section class="space-y-6 lg:col-span-2">
                <form @submit.prevent="savePermissions">
                    <div class="h-full rounded-md border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <h3 class="flex items-center gap-2 text-lg font-bold">
                                <i class="pi pi-lock text-primary"></i>
                                Permissions & Access
                            </h3>
                            <div class="flex items-center gap-2">
                                <Checkbox inputId="all_permissions" :modelValue="isAllSelected"
                                    @update:modelValue="toggleAll" :binary="true" />
                                <label for="all_permissions" class="capitalize cursor-pointer">
                                    Select All
                                </label>
                            </div>
                        </div>

                        <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-8 space-y-4">
                            <div v-for="(permissionGroup, groupName) in permissionGroups" :key="groupName"
                                class="rounded-lg bg-white p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <p class="capitalize font-bold text-slate-700">{{ groupName }}</p>
                                    <div class="flex items-center gap-2">
                                        <Checkbox :inputId="`group_${groupName}`"
                                            :modelValue="isGroupSelected(groupName)"
                                            @update:modelValue="toggleGroup(groupName)" :binary="true" />
                                        <label :for="`group_${groupName}`" class="capitalize cursor-pointer text-sm">
                                            Select All {{ groupName }}
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-slate-200">
                                <div class="flex flex-wrap gap-4">
                                    <div v-for="permission in permissionGroup" :key="permission.id"
                                        class="flex items-center gap-2">
                                        <Checkbox :inputId="`permission_${permission.id}`"
                                            :modelValue="isPermissionSelected(permission.id)"
                                            @update:modelValue="togglePermission(permission.id)" :binary="true" />
                                        <label :for="`permission_${permission.id}`"
                                            class="capitalize cursor-pointer text-sm">
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-4">
                            <p class="text-sm text-slate-600">
                                Selected: {{ form.permissions.length }} / {{ allPermissionIds.length }}
                            </p>
                            <Button icon="pi pi-save" label="Save Permissions" type="submit" :loading="form.processing"
                                :disabled="form.processing || role.data.isSystem" />
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped></style>