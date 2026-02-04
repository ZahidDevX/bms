<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Password from 'primevue/password';

const form = useForm({
    password: '',
    email: '',
});
const submit = () => {
    form.post(route('login'));
};
</script>

<template>
    <div class="min-h-screen bg-slate-100">
        <div class="xxl:container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div>
                    <img src="" alt="" />
                </div>
                <div class="flex min-h-screen items-center justify-center border-l border-slate-300 p-10 md:p-20">
                    <div class="bg-white p-6 rounded border border-slate-300 w-full">
                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="flex flex-col gap-1">
                                <InputText name="email" type="text" placeholder="Email" />
                                <Message v-if="form.errors.email" severity="error" size="small" variant="simple">{{
                                    form.errors.email
                                }}</Message>
                            </div>
                            <div class="flex flex-col gap-1">
                                <Password name="password" placeholder="Password" toggleMask :fluid="true"/>
                                <Message v-if="form.errors.password" severity="error" size="small" variant="simple">{{
                                    form.errors.password
                                }}</Message>
                            </div>
                            <div class="flex flex-col gap-1 items-end">
                                <Link href="#" class="text-md">Forgot Password?</Link>
                            </div>
                            <Button type="submit" severity="secondary" label="Submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
