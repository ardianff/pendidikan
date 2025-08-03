<?php

namespace Database\Seeders;

use App\Lib\Services;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\MasterKotaKab;
use App\Models\MasterProvinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('max_execution_time', 680000000);
        ini_set('memory_limit', '2G');

        $provinsi = Services::MasterMigrasi('masterprovinsisatset');
        foreach ($provinsi as $item) {
            MasterProvinsi::updateOrCreate(['kode_provinsi' => $item['kode_provinsi']], $item);
        }
        $kotakab = Services::MasterMigrasi('masterkotakabsatset');
        foreach ($kotakab as $item) {
            MasterKotaKab::updateOrCreate(['kode_kota_kab' => $item['kode_kota_kab']], $item);
        }
        $kecamatan = Services::MasterMigrasi('masterkecamatansatset');
        foreach ($kecamatan as $item) {
            MasterKecamatan::updateOrCreate(['kode_kecamatan' => $item['kode_kecamatan']], $item);
        }
        $kelurahan = Services::MasterMigrasi('masterkelurahansatset');
        foreach ($kelurahan as $item) {
            MasterKelurahan::updateOrCreate(['kode_kelurahan' => $item['kode_kelurahan']], $item);
        }
    }
}
