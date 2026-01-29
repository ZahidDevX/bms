<script setup lang="ts">
import { useLayout } from '@/layouts/composables/layout';
import { Link } from '@inertiajs/vue3';
import { ref } from "vue";

import Button from 'primevue/button';
import Menu from 'primevue/menu';

const { toggleMenu, toggleDarkMode, isDarkTheme } = useLayout();

const menu = ref();
const items = ref([
    {
        items: [
            {
                label: 'Profile',
                icon: 'pi pi-user'
            },
            {
                label: 'Sign Out',
                icon: 'pi pi-sign-out',
            }
        ]
    }
]);

const toggle = (event) => {
    menu.value.toggle(event);
};
</script>

<template>
    <div class="layout-topbar">
        <div class="layout-topbar-logo-container">
            <button class="layout-menu-button layout-topbar-action" @click="toggleMenu">
                <i class="pi pi-bars"></i>
            </button>
            <Link href="#" class="layout-topbar-logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36"><title xmlns="">letter-b</title><path fill="#3B88C3" d="M36 32a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4h28a4 4 0 0 1 4 4z"/><path fill="#FFF" d="M10.498 9.249c0-1.488 1.023-2.325 2.449-2.325H18.9c3.224 0 5.83 2.17 5.83 5.457c0 2.17-.9 3.628-2.885 4.558v.062c2.637.372 4.713 2.573 4.713 5.271c0 4.372-2.914 6.729-7.193 6.729h-6.386c-1.427 0-2.481-.899-2.481-2.356zm4.651 6.418h2.419c1.519 0 2.511-.899 2.511-2.45c0-1.457-1.147-2.201-2.511-2.201h-2.419zm0 9.24h3.659c1.674 0 2.915-.961 2.915-2.697c0-1.458-1.117-2.45-3.287-2.45h-3.287z"/></svg>

                <span>BMS</span>
            </Link>
        </div>

        <div class="layout-topbar-actions">
            <div class="layout-config-menu">
                <button type="button" class="layout-topbar-action" @click="toggleDarkMode">
                    <i :class="['pi', { 'pi-moon': isDarkTheme, 'pi-sun': !isDarkTheme }]"></i>
                </button>
                
            </div>

            <div class="layout-topbar-menu hidden lg:block">
                <div class="layout-topbar-menu-content">
                    <Button type="button" icon="pi pi-user" class="" @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" />
                    <Menu ref="menu" id="profile_menu" :model="items" :popup="true" />
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped></style>