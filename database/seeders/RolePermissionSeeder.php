<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissiongroups = [
            'User',
            'Role',
            'Permission Group',
            'Permission',
            'Menu',
            'Article Category',
            'Article',
            'Setting',
            'Banner',
            'Profil Komunitas',
            'Stuktural',
            'Galery',
            'Kegiatan',
        ];

        foreach ($permissiongroups as $permissiongroup) {
            PermissionGroup::create([
                'name' => $permissiongroup
            ]);
        }

        $permissions = [
            'User Access-1',
            'User Detail-1',
            'User Create-1',
            'User Update-1',
            'User Banned-1',
            'User Role Create-1',
            'Role Access-2',
            'Role Detail-2',
            'Role Create-2',
            'Role Update-2',
            'Role Delete-2',
            'Permission Group Access-3',
            'Permission Group Create-3',
            'Permission Group Update-3',
            'Permission Group Delete-3',
            'Permission Access-4',
            'Permission Create-4',
            'Permission Update-4',
            'Permission Delete-4',
            'Menu Access-5',
            'Menu Create-5',
            'Menu Update-5',
            'Menu Delete-5',
            'Article Category Access-6',
            'Article Category Create-6',
            'Article Category Update-6',
            'Article Category Delete-6',
            'Article Access-7',
            'Article Detail-7',
            'Article Create-7',
            'Article Update-7',
            'Article Delete-7',
            'Setting Access-8',
            'Setting Detail-8',
            'Setting Create-8',
            'Setting Update-8',
            'Setting Delete-8',
            'Banner Access-9',
            'Banner Detail-9',
            'Banner Create-9',
            'Banner Update-9',
            'Banner Delete-9',
            'Profil Komunitas Access-10',
            'Profil Komunitas Detail-10',
            'Profil Komunitas Create-10',
            'Profil Komunitas Update-10',
            'Profil Komunitas Delete-10',
            'Stuktural Access-11',
            'Stuktural Detail-11',
            'Stuktural Create-11',
            'Stuktural Update-11',
            'Stuktural Delete-11',
            'Galery Access-12',
            'Galery Detail-12',
            'Galery Create-12',
            'Galery Update-12',
            'Galery Delete-12',
            'Kegiatan Access-13',
            'Kegiatan Detail-13',
            'Kegiatan Create-13',
            'Kegiatan Update-13',
            'Kegiatan Delete-13',
        ];

        foreach ($permissions as $permission) {
            $permission_array = explode("-", $permission);
            Permission::create([
                'name' => $permission_array[0],
                'permission_group_id' => $permission_array[1]
            ]);
        }

        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $admin->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'User',
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo('Article Access');
    }
}
