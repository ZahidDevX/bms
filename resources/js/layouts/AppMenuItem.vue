<script setup lang="ts">
import { useLayout } from '@/layouts/composables/layout';
import { Link } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
const { layoutState } = useLayout();

const props = defineProps({
    item: { type: Object, default: () => ({}) },
    root: { type: Boolean, default: true },
});

const hasActiveChild = (item) => {
    if (item.items) {
        for (let child of item.items) {
            if (child.to && window.location.href == child.to) {
                return true;
            } else if (child.items && hasActiveChild(child)) {
                return true;
            }
        }
    }
    return false;
};

const isOpen = ref(false);


const isActive = computed(() => {
    // Direct active
    if (props.item.to && window.location.href == props.item.to) {
        return true;
    }

    // Parent active if any child is active
    if (props.item.items) {
        return hasActiveChild(props.item);
    }

    return false;
});


const itemClick = (event, item) => {
    if (item.disabled) {
        event.preventDefault();
        return;
    }

    if (item.command) {
        item.command({ originalEvent: event, item });
    }

    // Toggle only for parent menus
    if (item.items) {
        event.preventDefault(); // prevent <a> navigation
        isOpen.value = !isOpen.value;
    } else {
        layoutState.overlayMenuActive = false;
        layoutState.mobileMenuActive = false;
        layoutState.menuHoverActive = false;
    }
};

watch(
    () => hasActiveChild(props.item),
    (hasActive) => {
        if (hasActive) {
            isOpen.value = true;
        }
    },
    { immediate: true }
);
</script>
<template>
    <li :class="{ 'layout-root-menuitem': root, 'active-menuitem': isActive }">
        <div v-if="root && item.visible !== false" class="layout-menuitem-root-text">{{ item.label }}</div>
        <a
            v-if="(!item.to || item.items) && item.visible !== false"
            :href="item.url"
            @click="itemClick($event, item)"
            :class="item.class"
            :target="item.target"
            tabindex="0"
        >
            <i :class="item.icon" class="layout-menuitem-icon" /> <span class="layout-menuitem-text">{{ item.label }}</span>
            <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items" />
        </a>
        <Link
            :href="item.to"
            v-if="item.to && !item.items && item.visible !== false"
            @click="itemClick($event, item)"
            exactActiveClass="active-route"
            :class="item.class"
            tabindex="0"
            :to="item.to"
        >
            <i :class="item.icon" class="layout-menuitem-icon" /> <span class="layout-menuitem-text">{{ item.label }}</span>
            <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items" />
        </Link>
        <Transition v-if="item.items && item.visible !== false" name="layout-submenu">
            <ul v-show="root ? true : isOpen" class="layout-submenu">
                <app-menu-item
                    v-for="child in item.items"
                    :key="child.label + '_' + (child.to || child.path)"
                    :item="child"
                    :root="false"
                />
            </ul>
        </Transition>
    </li>
</template>
<style scoped>
.active-menuitem > a{
    color: var(--primary-color);
}
</style>