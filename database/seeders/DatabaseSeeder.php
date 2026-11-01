<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Services;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        DB::table('roles')->updateOrInsert(['id' => 1], ['name' => 'admin', 'guard_name' => 'web']);
        DB::table('roles')->updateOrInsert(['id' => 2], ['name' => 'client', 'guard_name' => 'web']);

        // 2. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'mobile' => '9876543210',
                'role_id' => 1,
                'is_deleted' => 0,
            ]
        );

        // 3. Seed Basic Categories
        $categories = [
            ['name' => 'Clothes', 'short_name' => 'CL', 'status' => 1],
            ['name' => 'Upholstery', 'short_name' => 'UP', 'status' => 1],
            ['name' => 'Footwear & Bags', 'short_name' => 'FB', 'status' => 1],
            ['name' => 'Laundry', 'short_name' => 'LN', 'status' => 1],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 4. Seed Basic Services / Operations
        $services = [
            ['name' => 'Dry Cleaning', 'short_name' => 'DC'],
            ['name' => 'Wash & Fold', 'short_name' => 'WF'],
            ['name' => 'Wash & Iron', 'short_name' => 'WI'],
            ['name' => 'Steam Press', 'short_name' => 'SP'],
        ];
        foreach ($services as $srv) {
            Services::firstOrCreate(['name' => $srv['name']], $srv);
            Service::firstOrCreate(['name' => $srv['name']]);
        }
        // 5. Seed Full Dummy Data
        $this->call(DummyDataSeeder::class);
    }
}
