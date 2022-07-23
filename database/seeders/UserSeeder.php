<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin Test',
            'email'     => 'admin@test.com',
            'password'  => bcrypt('123456'),
            'nip'       => '1557301091',
            'role'      => 'admin',
        ]);

        User::create([
            'name'      => 'Manager Test',
            'email'     => 'manager@test.com',
            'password'  => bcrypt('123456'),
            'nip'       => '1557301092',
            'role'      => 'manager',
        ]);

        User::create([
            'name'      => 'Auditor Test',
            'email'     => 'auditor@test.com',
            'password'  => bcrypt('123456'),
            'nip'       => '1557301093',
            'role'      => 'auditor',
        ]);

        User::create([
            'name'      => 'Auditee Test',
            'email'     => 'auditee@test.com',
            'password'  => bcrypt('123456'),
            'nip'       => '1557301094',
            'role'      => 'auditee',
        ]);
    }
}
