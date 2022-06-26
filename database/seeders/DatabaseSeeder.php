<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('admins')->delete();

        DB::table('admins')->insert([
            'name' => 'Carsbn Admin',
           'email' => 'superadmin@gmail.com',
           'password' => Hash::make('12345678'),
           'is_super' => 1,
           'status'  => 'Active',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
       ]);

    }
}
