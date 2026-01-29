<?php

namespace App\Services\Core;

class SidebarMenuService
{
    public function getMenuItems(): array
    {
        $menuItems = [];

        $menuItems[] = $this->homeMenuItem();

        return $menuItems;
    }

    private function homeMenuItem(): array
    {
        return [
            'label' => 'Home',
            'icon' => 'home-icon',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'pi pi-fw pi-home',
                    'to' => route('dashboard')
                ],
            ],
        ];
    }
}
