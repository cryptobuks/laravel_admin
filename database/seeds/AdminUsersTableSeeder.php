<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=AdminUsersTableSeeder
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        User::create(['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('123456')]);
//        User::create(['name' => 'winter', 'email' => 'winter@gmail.com', 'password' => bcrypt('123qweasd')]);
    }
}
