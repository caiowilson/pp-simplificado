<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::create(['name' => 'user']);
        $userRole->permissions()->attach(Permission::pluck('id'));
 
        $sellerRole = Role::create(['name' => 'seller']);
        $sellerRole->permissions()->attach(
            Permission::where('name', '!=', 'transaction.send')->pluck('id')
        );
    }
}
