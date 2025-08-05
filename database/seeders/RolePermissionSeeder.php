<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role Admin/Petugas
        $admin = Role::create(['name' => 'admin']);
        $petugas = Role::create(['name' =>'petugas']);

        // Permission
        $kelolaObat = Permission::create(['name' => 'kelola obat']);
        $lihatObat = Permission::create(['name' => 'lihat obat']);

        // Role X Permission
        $admin->givePermissionTo([$kelolaObat]);
        $petugas->givePermissionTo([$lihatObat]);
    }
}
