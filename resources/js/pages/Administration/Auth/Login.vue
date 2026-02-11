<script setup lang="ts">

import {  } from '@/wayfinder/routes/auth';
import login from '@/wayfinder/routes/auth/login';
import request from '@/wayfinder/routes/password/request';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';

const page = usePage();

defineProps<{
    bgImage: string;
}>();

const form = useForm({
    email: 'developer@mustamirun.agency',
    password: 'password#',
    remember: false,
});

const submit = () => {
    form.submit(login.process(), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>
<template>
    <div
        class="relative z-[1] flex min-h-screen items-center justify-center !bg-cover !bg-center !bg-no-repeat px-6 py-20 backdrop-blur-2xl after:absolute after:inset-0 after:z-[-1] after:bg-black/50 after:content-[''] md:px-20 lg:px-80"
        :style="{ backgroundImage: `url(${bgImage})` }"
    >
        <div class="flex w-full max-w-sm flex-col items-center gap-12 rounded-2xl border border-white/10 bg-white/10 px-8 py-12 backdrop-blur-2xl">
            <div class="flex w-full flex-col items-center gap-4">
                <div class="flex w-full flex-col gap-2">
                    <div class="text-center text-3xl leading-tight font-medium text-white">Welcome Back</div>
                </div>
            </div>
                <Message severity="success" v-if="page.props.flash.status">{{ page.props.flash.status }}</Message>

            <form @submit.prevent="submit" class="flex w-full flex-col items-center gap-8">
                <div class="flex w-full flex-col gap-6">
                    <div class="space-y-2">
                        <IconField>
                            <InputIcon class="pi pi-envelope text-white/70!" />
                            <InputText
                                type="text"
                                v-model="form.email"
                                class="w-full! appearance-none! border! border-white/10! bg-white/10! text-white! shadow-sm! outline-0! placeholder:text-white/70!"
                                placeholder="Email"
                            />
                        </IconField>
                        <Message size="small" severity="error" variant="simple">{{ form.errors.email }}</Message>
                    </div>
                    <div class="space-y-2">
                        <IconField>
                            <InputIcon class="pi pi-lock text-white/70!" />
                            <InputText
                                type="password"
                                v-model="form.password"
                                class="w-full! appearance-none! border! border-white/10! bg-white/10! text-white! shadow-sm! outline-0! placeholder:text-white/70!"
                                placeholder="Password"
                            />
                        </IconField>
                        <Message size="small" severity="error" variant="simple">{{ form.errors.password }}</Message>
                    </div>
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.remember" inputId="remember" name="remember" binary :value="form.remember" />
                        <label for="remember" class="text-white"> Remember me </label>
                    </div>
                </div>
                <Button
                    type="submit"
                    label="Sign In"
                    class="bg-surface-950! border-surface-950! hover:bg-surface-950/80! w-full! rounded-3xl! border! text-white!"
                />
            </form>
            <Link :href="request.form()" class="cursor-pointer text-white/80 hover:text-white/90">Forgot Password?</Link>
        </div>
    </div>
</template>
