<script setup lang="ts">
import dashboard from '@/wayfinder/routes/dashboard';
import verification from '@/wayfinder/routes/verification';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
</script>
<template>
    <div class="flex min-h-screen items-center justify-center bg-emerald-50">
        <div class="w-full max-w-lg space-y-6 rounded-lg border border-emerald-200 bg-white p-10 shadow">
            <div class="!space-y-1 text-center">
                <i class="pi pi-envelope !text-4xl"></i>
                <h1 class="!text-2xl">Please Verify Your Email Address</h1>
            </div>
            <div class="space-y-4 text-center">
                <p>Your registration almost done. We sent an email to your mail account.</p>
                <p>Just click on the button <strong>"Verify Email Address"</strong> in that email to complete your registration.</p>
                <Button
                    type="button"
                    :as="Link"
                    :href="verification.send()"
                    label="Resend Email"
                    class="bg-surface-950! border-surface-950! hover:bg-surface-950/80! w-full! rounded-3xl! border! text-white!"
                />
                <p>
                    Already Verified?
                    <Link :href="dashboard.index()" class="text-emerald-500">Dashboard</Link>
                </p>
            </div>
        </div>
    </div>
</template>
<style scoped></style>
