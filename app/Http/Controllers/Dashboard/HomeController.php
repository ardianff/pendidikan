<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MasterJenjangMadrasah;
use App\Models\MasterMadrasah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Menghitung total madrasah aktif yang terverifikasi
        $totalMadrasah = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->count();
        $totalMadrasahNegeri = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('status', '=', 'Negeri')
            ->count();
        $totalMadrasahSwasta = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('status', '=', 'Swasta')

            ->count();

        $totalRa = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('jenjang', 1) // RA
            ->count();
        $totalMi = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('jenjang', 2) // MI
            ->count();
        $totalMts = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('jenjang', 3) // MTs
            ->count();
        $totalMa = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('jenjang', 4) // MA
            ->count();
        $totalMak = MasterMadrasah::where('active', true)
            ->where('isVerif', true)
            ->where('jenjang', 5) // MAK
            ->count();

        // Mengembalikan data ke view
        return view('pages.dashboard.index', [
            'totalMadrasah' => $totalMadrasah,
            'totalRa' => $totalRa,
            'totalMi' => $totalMi,
            'totalMts' => $totalMts,
            'totalMa' => $totalMa,
            'totalMak' => $totalMak,
            'totalMadrasahNegeri' => $totalMadrasahNegeri,
            'totalMadrasahSwasta' => $totalMadrasahSwasta,
        ]);
    }
}
