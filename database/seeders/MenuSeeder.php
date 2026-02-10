<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // === Menu 1: Artikel ===
        $artikel = Menu::create([
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 7, 
            'icon'               => 'ri-article-line',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel Kategori',
            'permission_group_id'=> 7,
            'href'               => '/article_categories',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 7,
            'href'               => '/article',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Menu 2: Setting ===
        $setting = Menu::create([
            'nama_menu'          => 'Setting',
            'permission_group_id'=> 8,
            'icon'               => 'ri-settings-3-line',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // Submenu User Management
        $userManagement = Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'User Management',
            'permission_group_id'=> 8,
            'status'             => '1',
            'sort'               => '1',
        ]);

        // Level 3 dari User Management
        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Users',
            'permission_group_id'=> 1,
            'href'               => '/user',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permission Group',
            'permission_group_id'=> 8,
            'href'               => '/permissiongroup',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permissions',
            'permission_group_id'=> 8,
            'href'               => '/permission',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Roles',
            'permission_group_id'=> 8,
            'href'               => '/role',
            'status'             => '1',
            'sort'               => '4',
        ]);

        // Submenu Web Setting (langsung di bawah Setting)
        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Web Setting',
            'permission_group_id'=> 8,
            'href'               => '/setting',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Management',
            'permission_group_id'=> 8,
            'href'               => '/menu',
            'status'             => '1',
            'sort'               => '3',
        ]);

        $banner = Menu::create([
            'nama_menu'          => 'Banner',
            'permission_group_id'=> 9, 
            'icon'               => 'ri-advertisement-line',
            'status'             => '1',
            'sort'               => '3',
            'href'               => '/banner',
        ]);
        
        $profilKomunitas = Menu::create([
            'nama_menu'          => 'Profil Komunitas',
            'permission_group_id'=> 10, 
            'icon'               => 'ri-community-line',
            'status'             => '1',
            'sort'               => '3',
            'href'               => '/profil',
        ]);

        $stuktural = Menu::create([
            'nama_menu'           => 'Struktural',
            'permission_group_id' => 11,
            'icon'                => 'ri-team-line',
            'status'              => '1',
            'sort'                => '3',
            'href'                => '/stuktural',
        ]);

        $galery = Menu::create([
            'nama_menu'           => 'Galery',
            'permission_group_id' => 12,
            'icon'                => 'ri-image-line',
            'status'              => '1',
            'sort'                => '3',
            'href'                => '/galery',
        ]);

        $kegiatan = Menu::create([
            'nama_menu'           => 'Kegiatan',
            'permission_group_id' => 13,
            'icon'                => 'ri-calendar-event-line',
            'status'              => '1',
            'sort'                => '3',
            'href'                => '/kegiatan',
        ]);

    }
}