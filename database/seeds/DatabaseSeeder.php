<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsAndRolesSeeder::class);
        $this->call(RolesToUserSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(CallLogTableSeeder::class);
    }
}
