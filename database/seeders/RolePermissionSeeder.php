<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1) Daftar roles
        $roles = [
            'superadmin',
            'admin',
            'kankemenag',
            'madrasah',
        ];

        // 2) Buat permission default untuk tiap module: "manage-{role}"
        $permissions = collect($roles)
            ->filter(fn($r) => ! in_array($r, ['superadmin', 'admin']))
            ->map(fn($r) => 'manage ' . $r)
            ->toArray();

        // 3) Tambahkan permission untuk admin/superadmin
        $permissions = array_merge($permissions, [
            // superadmin nanti akan punya semuanya
            // admin kita beri juga manage semua module
            'manage superadmin',
            'manage admin',
        ]);

        // 4) Buat atau ambil permission di database
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 5) Buat roles dan assign permission
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if ($roleName === 'superadmin') {
                // superadmin = semua permission
                $role->syncPermissions(Permission::all());
            } elseif ($roleName === 'admin') {
                // admin = semua permission kecuali manage superadmin
                $allButSuper = Permission::where('name', '!=', 'manage superadmin')->get();
                $role->syncPermissions($allButSuper);
            } else {
                // role module = hanya manage-{module}
                $role->syncPermissions("manage {$roleName}");
            }
        }
    }
}
