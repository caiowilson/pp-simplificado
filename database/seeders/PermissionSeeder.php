<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'transaction.send']);
        Permission::create(['name' => 'transaction.receive']);
        Permission::create(['name' => 'transaction.list']);
        // Permission::create(['name' => 'transaction.delete']);
    }
}
