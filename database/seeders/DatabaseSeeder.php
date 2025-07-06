<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Department;
use App\Models\Program;
use App\Models\SchoolYear;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (User::count() === 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@ccc.com',
                'role' => Role::Admin,
                'password' => \Hash::make('Welcome123'),
            ]);
        }

        $this->call([
            ProgramSeeder::class,
        ]);
    }
}
