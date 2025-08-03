<?php

namespace Database\Seeders;

use App\Models\MasterJenjangMadrasah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenjang = [
            [
                "nama" => "Raudhatul Athfal",
                "alias" => "RA",
                "active" => true
            ],
            [
                "nama" => "Madrasah Ibtidaiyah",
                "alias" => "MI",
                "active" => true
            ],
            [
                "nama" => "Madrasah Tsanawiyah",
                "alias" => "MTs",
                "active" => true
            ],
            [
                "nama" => "Madrasah Aliyah",
                "alias" => "MA",
                "active" => true
            ],
            [
                "nama" => "Madrasah Aliyah Kejuruan",
                "alias" => "MAK",
                "active" => true
            ],
        ];

        foreach ($jenjang as $jen) {
            MasterJenjangMadrasah::updateOrCreate($jen, $jen);
        }
    }
}
