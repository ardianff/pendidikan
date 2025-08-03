<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MasterJenjangMadrasah;
use App\Models\MasterKotaKab;
use App\Models\MasterMadrasah;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function dataMadrasah()
    {
        try {
            // // Total madrasah aktif dan terverifikasi
            // $totalMadrasah = MasterMadrasah::where('active', true)
            //     ->where('isVerif', true)
            //     ->count();

            // Ambil semua jenjang aktif
            $jenjang = MasterJenjangMadrasah::where('active', true)->get();
            $jenjangNames = $jenjang->pluck('nama')->toArray();

            // // Hitung jumlah negeri/swasta per jenjang (sesuai kebutuhan lain)
            // $seriesNegeri = [];
            // $seriesSwasta = [];
            // foreach ($jenjang as $j) {
            //     $seriesNegeri[] = MasterMadrasah::where('active', true)
            //         ->where('isVerif', true)
            //         ->where('status', 'Negeri')
            //         ->where('jenjang', $j->id)
            //         ->count();

            //     $seriesSwasta[] = MasterMadrasah::where('active', true)
            //         ->where('isVerif', true)
            //         ->where('status', 'Swasta')
            //         ->where('jenjang', $j->id)
            //         ->count();
            // }

            // // Ambil daftar kabupaten/kota di Jateng
            // $kabupatens = MasterKotaKab::where('kode_parent', '33')
            //     ->orderBy('nama', 'asc')
            //     ->get();

            // // Siapkan kategori kabupaten
            // $categoriesKab = $kabupatens->pluck('nama')->toArray();

            // // Detail jumlah madrasah per jenjang per kabupaten
            // $byJenjangPerKab = [];
            // foreach ($jenjang as $j) {
            //     $dataPerKab = [];
            //     foreach ($kabupatens as $kb) {
            //         $count = MasterMadrasah::where('active', true)
            //             ->where('isVerif', true)
            //             ->where('kab_kota', $kb->kode_kota_kab)
            //             ->where('jenjang', $j->id)
            //             ->count();
            //         $dataPerKab[] = $count;
            //     }
            //     $byJenjangPerKab[] = [
            //         'name' => $j->nama,
            //         'data' => $dataPerKab
            //     ];
            // }
            $madrasahData = [];
            foreach ($jenjang as $j) {
                // Hitung jumlah Madrasah Negeri per Jenjang
                $countNegeri = MasterMadrasah::where('active', true)
                    ->where('isVerif', true)
                    ->where('status', 'Negeri')
                    ->where('jenjang', $j->id)
                    ->count();

                // Hitung jumlah Madrasah Swasta per Jenjang
                $countSwasta = MasterMadrasah::where('active', true)
                    ->where('isVerif', true)
                    ->where('status', 'Swasta')
                    ->where('jenjang', $j->id)
                    ->count();

                // Format data per jenjang
                $madrasahData[] = [
                    $j->nama,        // Jenjang name (e.g., Raudhatul Athfal, Madrasah Ibtidaiyah, etc.)
                    $countNegeri,    // Count of Negeri Madrasah
                    $countSwasta     // Count of Swasta Madrasah
                ];
            }
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data madrasah',
                'data' => [
                    // 'total'      => $totalMadrasah,
                    'madrasah'   => $madrasahData,
                    // 'jenjang'    => $jenjangNames,
                    // 'by_jenjang' => [
                    //     'categories' => $jenjangNames,
                    //     'series'     => [
                    //         ['name' => 'Negeri', 'data' => $seriesNegeri],
                    //         ['name' => 'Swasta', 'data' => $seriesSwasta]
                    //     ]
                    // ],
                    // 'by_kabupaten' => [
                    //     'categories' => $categoriesKab,
                    //     'series'     => $byJenjangPerKab
                    // ]
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ], 500);
        }
    }
}
