<?php

namespace App\Services\Core;

class SidebarMenuService
{
    public function getMenuItems(): array
    {
        $menuItems = [];

        $menuItems[] = $this->homeMenuItem();
        $menuItems[] = $this->settingsMenuItem();

        return $menuItems;
    }

    /**
     * Home Menu
     */
    private function homeMenuItem(): array
    {
        return [
            'label' => 'Home',
            'icon' => 'home-icon',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'pi pi-fw pi-home',
                    'to' => route('dashboard.index')
                ],
            ],
        ];
    }

    /**
     * Settings Menu
     */
    private function settingsMenuItem(): array
    {
        $settingsMenu = [];

        // Roles Menu
        $settingsMenu[] = [
            'label' => 'Roles',
            'icon' => 'pi pi-key',
            'to' => route('roles.index')
        ];

        if (!empty($settingsMenu)) {
            return [
                'label' => 'Settings',
                'icon' => 'pi pi-cog',
                'items' => $settingsMenu
            ];
        }
        return [];
    }
}
