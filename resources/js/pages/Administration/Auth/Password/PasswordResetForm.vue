<script setup lang="ts">
import login from '@/wayfinder/routes/auth/login';
import password from '@/wayfinder/routes/password';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Password from 'primevue/password';

const page = usePage();

const props = defineProps<{
    token: string;
    email: string;
}>();

const form = useForm({
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        token: props.token,
    })).submit(password.reset.process(), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
<template>
    <div class="flex min-h-screen items-center justify-center bg-emerald-50">
        <div class="w-full max-w-lg space-y-6 rounded-lg border border-emerald-200 bg-white p-10 shadow">
            <div class="!space-y-1 text-center">
                <i class="pi pi-key !text-4xl"></i>
                <h1 class="!text-2xl">Reset Password</h1>
                <p class="text-sm text-slate-500">Please kindly set your new password.</p>
            </div>
            <div class="space-y-4">
                <Message severity="success" v-if="page.props.flash.status">{{ page.props.flash.status }}</Message>
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="space-y-4">
                        <IconField>
                            <InputIcon class="pi pi-envelope" />
                            <InputText v-model="form.email" placeholder="user@example.com" :fluid="true" :readonly="true" />
                        </IconField>
                        <Message size="small" severity="error" variant="simple">{{ form.errors.email }}</Message>
                    </div>
                    <div class="space-y-4">
                        <IconField>
                            <InputIcon class="pi pi-key" />
                            <Password v-model="form.password" :feedback="false" toggleMask :fluid="true" />
                        </IconField>
                        <Message size="small" severity="error" variant="simple">{{ form.errors.password }}</Message>
                    </div>
                    <div class="space-y-4">
                        <IconField>
                            <InputIcon class="pi pi-key" />
                            <Password v-model="form.password_confirmation" :feedback="false" toggleMask :fluid="true" />
                        </IconField>
                        <Message size="small" severity="error" variant="simple">{{ form.errors.password_confirmation }}</Message>
                    </div>
                    <div>
                        <Button
                            type="submit"
                            label="Update Password"
                            class="bg-surface-950! border-surface-950! hover:bg-surface-950/80! w-full! rounded-3xl! border! text-white!"
                        />
                    </div>
                </form>
                <Link :href="login.form()" class="mx-auto flex w-fit items-center gap-2 hover:text-emerald-500">
                    <i class="pi pi-chevron-left"></i>
                    Back To Login
                </Link>
            </div>
        </div>
    </div>
</template>
<style scoped></style>
