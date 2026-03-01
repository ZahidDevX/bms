<script setup lang="ts">
import DeleteModal from '@/components/Administration/DeleteModal.vue';
import InfoLine from '@/components/Administration/InfoLine.vue';
import PageHeader from '@/components/Administration/PageHeader.vue';
import StatusChanger from '@/components/Administration/StatusChanger.vue';
import TextInput from '@/components/Administration/TextInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import roles from '@/wayfinder/routes/roles';
import { Head, Link, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Menu from 'primevue/menu';
import Select from 'primevue/select';
import { reactive, ref } from 'vue';
import RoleCreate from './RoleCreate.vue';
import RoleEdit from './RoleEdit.vue';

// Props
interface Role {
    id: number;
    name: string;
    order: number;
    status: boolean;
    isSystem: boolean;
    isAssignable: boolean;
}

interface RolesCollection {
    data: Role[];
}

const { rolesData, filters } = defineProps<{
    rolesData: RolesCollection;
    filters: {
        status: string;
        search: string;
    };
}>();

// Filter Form
const statusOptions = [
    { label: 'Active', value: 'active' },
    { label: 'Inactive', value: 'inactive' },
];
const filterForm = reactive({
    status: filters.status ?? '',
    search: filters.search ?? '',
});

const filterRoles = () => {
    router.get(roles.index().url, filterForm, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Action Menu
const menu = ref<InstanceType<typeof Menu>[]>([]);

const getActionMenuItems = (role: Role) => [
    {
        label: 'Actions',
        items: [
            {
                label: 'View Details',
                icon: 'pi pi-eye',
                command: () => {
                    router.get(roles.show({ role: role.id }));
                },
            },
            {
                label: 'Edit Role',
                icon: 'pi pi-file-edit',
                command: () => {
                    openEditModal(role);
                },
            },
            {
                label: 'Delete Role',
                icon: 'pi pi-trash',
                command: () => {
                    confirmDeletion(roles.destroy({ role: role.id }).url);
                },
            },
        ],
    },
];

const toggle = (event: MouseEvent, index: number) => {
    menu.value[index].toggle(event);
};

// Role Create Modal
const modalVisibility = ref(false);

const changeModalVisibility = () => {
    modalVisibility.value = !modalVisibility.value;
};

// Role Edit Modal
const editModalVisibility = ref(false);
const selectedRole = ref<Role | null>(null);

const openEditModal = (role: Role) => {
    selectedRole.value = role;
    editModalVisibility.value = true;
};

const closeEditModal = () => {
    editModalVisibility.value = false;
    selectedRole.value = null;
};

// Delete Modal
const isDeleteModalVisible = ref(false);
const selectedRoleDeleteRoute = ref('');

const confirmDeletion = (roleRoute: string) => {
    selectedRoleDeleteRoute.value = roleRoute;
    isDeleteModalVisible.value = true;
};

</script>

<template>

    <Head title="Roles Management" />
    <AppLayout>
        <PageHeader title="Roles Management" description="Manage User's Roles & Permissions" icon="pi pi-key">
            <template #buttons>
                <Button @click="changeModalVisibility" label="Add New Role" icon="pi pi-plus"
                    variant="outlined"></Button>
            </template>
        </PageHeader>

        <!-- =========== Records Listing Section Start =========== -->
        <section class="mb-6 space-y-3 rounded-md bg-white p-4">
            <div class="grid items-center gap-4 md:grid-cols-5">
                <div class="col-span-full flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-filter"></i>
                        <p class="text-lg font-bold">Filter</p>
                    </div>
                    <div>
                        <Button label="Clear" icon="pi pi-filter" variant="outlined" severity="secondary" size="small"
                            :as="Link" :href="roles.index().url" />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="filter-status">Select Status</label>
                    <Select v-model="filterForm.status" :options="statusOptions" option-label="label"
                        option-value="value" placeholder="Select Status" id="filter-status" :fluid="true"
                        :show-clear="true" />
                </div>

                <div class="col-span-2 flex flex-col gap-2">
                    <TextInput id="search" label="Search" v-model="filterForm.search" type="search" :required="false" :max-length="0" />
                </div>

                <div class="flex flex-col gap-2">
                    <label class="opacity-0">.</label>
                    <Button label="Filter" icon="pi pi-filter" @click="filterRoles" />
                </div>
            </div>
            <hr />
            <div class="space-y-4">
                <div v-for="(role, index) in rolesData.data" :key="role.id" class="rounded border border-slate-200 p-4">
                    <div class="grid md:grid-cols-12">
                        <div class="space-y-1 md:col-span-6">
                            <InfoLine label="Role Name" :value="role.name" />
                            <InfoLine label="Sort Order" :value="role.order" />
                        </div>
                        <div class="space-y-1 md:col-span-5">
                            <InfoLine label="Is System" :value="role.isSystem" />
                            <InfoLine label="Is Assignable" :value="role.isAssignable" />
                        </div>
                        <div class="flex items-center justify-end gap-4">
                            <template v-if="!role.isSystem">
                                <StatusChanger :status="role.status" :route="roles.changeStatus({ role: role }).url" />
                                <Button type="button" icon="pi pi-ellipsis-v" @click="toggle($event, index)"
                                    aria-haspopup="true" :aria-controls="'actionMenu_' + role.id" />
                                <Menu :ref="(el) => (menu[index] = el as any)" :key="role.id"
                                    :id="'actionMenu_' + role.id" :model="getActionMenuItems(role)" :popup="true" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =========== Records Listing Section End =========== -->
        <!-- =========== Role Create Modal Section Start =========== -->
        <RoleCreate :visible="modalVisibility" @close-modal="changeModalVisibility" />
        <!-- =========== Role Create Modal Section End =========== -->
        <!-- =========== Role Edit Modal Section Start =========== -->
        <RoleEdit :visible="editModalVisibility" :role="selectedRole" @close-modal="closeEditModal" />
        <!-- =========== Role Edit Modal Section End =========== -->

        <DeleteModal :visible="isDeleteModalVisible" :route="selectedRoleDeleteRoute"
            @close-modal="isDeleteModalVisible = false" />
    </AppLayout>
</template>

<style scoped></style>
