<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Major::create(
            [
                'name'  => 'Teknik Kimia'
            ]
        );

        Major::create(
            [
                'name'  => 'Teknologi Informasi dan Komputer'
            ]
        );

        Major::create(
            [
                'name'  => 'Teknik Mesin'
            ]
        );

        Major::create(
            [
                'name'  => 'Teknik Elektro'
            ]
        );

        Major::create(
            [
                'name'  => 'Tataniaga'
            ]
        );
    }
}
