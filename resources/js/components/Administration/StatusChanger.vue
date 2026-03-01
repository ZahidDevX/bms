<script setup lang="ts">
import { useNotify } from '@/composables/useNotify';
import { router } from '@inertiajs/vue3';
import ToggleSwitch from 'primevue/toggleswitch';

const { notify } = useNotify();

const props = defineProps<{
    status: boolean;
    route: string;
}>();

// Change Status
const changeStatus = () => {
    router.patch(
        props.route,
        {},
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
            },
            onError: (errors) => {
                notify('error', errors);
            },
        },
    );
};
</script>
<template>
    <div>
        <ToggleSwitch :default-value="status" @change="changeStatus" />
    </div>
</template>
<style scoped></style>
