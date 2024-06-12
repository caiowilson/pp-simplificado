<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create(['email' => 'user@user.com']);
        $user->roles()->attach(Role::where('name', 'user')->value('id'));

        $seller = User::factory()->create(['email' => 'seller@seller.com']);
        $seller->roles()->attach(Role::where('name', 'seller')->value('id'));
        
    }
}
