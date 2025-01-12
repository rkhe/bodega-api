<?php

namespace Database\Seeders;

// use Faker\Core\Number;

use App\Models\User;
use App\Models\Warehouse;
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use UserRoles;
use UserStatuses;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // demo user
        if (DB::scalar("select count(*) from users where name = 'admin'") == 0)
            DB::table('users')->insert([
                'name' => 'admin',// Str::random(10),
                'email' => 'admin'.'@example.com',
                'password' => Hash::make('password'),
                'user_role_id' => UserRoles::ADMINISTRATOR,
                'user_status_id' => UserStatuses::ACTIVE
            ]);

        // dummy data
        User::factory()->count(20)->create();
        Warehouse::factory()->count(10)->create();

    }
}
