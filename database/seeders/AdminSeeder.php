<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'  => 'Iqbal',
            'email'  => 'admin@admin',
            'password'  => bcrypt('admin'),
            'nip'  => '1557301091',
            'role'  => 'admin',
        ]);
    }
}
