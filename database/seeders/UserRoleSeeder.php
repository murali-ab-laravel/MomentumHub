<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Assuming users already exist
        $admin = User::find(3); // or use where('email', 'admin@example.com')->first();
        $investor = User::find(4);
        $business = User::find(5);

        // Assign roles
        $admin?->assignRole('admin');
        $investor?->assignRole('investor');
        $business?->assignRole('business');
    }
}

