<?php

namespace App\Lib;

use App\Models\MasterJenjangMadrasah;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\MasterKotaKab;
use App\Models\MasterOrganisasi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class Helpers
{
    public static function cekKabKota($prov, $pencarian)
    {
        try {
            $kabkota = MasterKotaKab::where("kode_parent", '=', $prov)->where('nama', 'ILIKE', '%' . $pencarian . '%')->first();
            return $kabkota;
        } catch (\Throwable $th) {
            throw new Exception('Data Kabupaten/Kota tidak ditemukan');
        }
    }

    public static function cekKecamatan($kabkota, $pencarian)
    {
        try {
            $kecamatan = MasterKecamatan::where("kode_parent", '=', $kabkota)->where('nama', 'ILIKE', '%' . $pencarian . '%')->first();
            return $kecamatan;
        } catch (\Throwable $th) {
            throw new Exception('Data Kecamatan tidak ditemukan');
        }
    }
    public static function cekKelurahanDesa($kecamatan, $pencarian)
    {
        try {
            $keldesa = MasterKelurahan::where("kode_parent", '=', $kecamatan)->where('nama', 'ILIKE', '%' . $pencarian . '%')->first();
            return $keldesa;
        } catch (\Throwable $th) {
            throw new Exception('Data Kelurahan/Desa tidak ditemukan');
        }
    }
    public static function cekJenjang($pencarian)
    {
        try {
            $jenjang = MasterJenjangMadrasah::where("active", '=', true)->where('nama', 'ILIKE', '%' . $pencarian . '%')->first();
            return $jenjang;
        } catch (\Throwable $th) {
            throw new Exception('Data Jenjang Madrasah tidak ditemukan');
        }
    }


    public static function cekAfiliasi($pencarian)
    {
        try {
            if (empty($pencarian) || $pencarian === '-') {
                return null;
            }

            // Menyiapkan data untuk organisasi
            $data = [
                'nama' => $pencarian,
                'active' => true,
            ];

            // Mencari atau membuat data organisasi
            $org = MasterOrganisasi::updateOrCreate(
                ['nama' => $pencarian], // Kondisi pencarian berdasarkan 'nama'
                $data // Data yang akan diperbarui atau dibuat
            );

            if ($org && isset($org->id)) {
                return $org->id;
            } else {
                throw new \Exception('Organisasi tidak ditemukan atau gagal dibuat.');
            }
        } catch (\Throwable $th) {
            throw new \Exception('Data Afiliasi Organisasi tidak ditemukan: ' . $th->getMessage());
        }
    }
}
