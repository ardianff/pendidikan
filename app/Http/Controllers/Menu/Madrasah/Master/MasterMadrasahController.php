<?php

namespace App\Http\Controllers\Menu\Madrasah\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Madrasah\Master\CheckMadrasahRequest;
use App\Models\MasterMadrasah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterMadrasahController extends Controller
{
    public function cekDataMadrasah(CheckMadrasahRequest $request)
    {
        try {
            if ($request->validated() && $request->ajax()) {
                $madrasah = $query = MasterMadrasah::with([
                    'dt_provinsi',
                    'dt_kotakab',
                    'dt_kecamatan',
                    'dt_keldesa',
                    'dt_jenjang',
                    'dt_afiliasi'
                ])
                    ->where('isVerif', 1)
                    ->where('active', 1);

                // Filter berdasarkan kabupaten/kota jika ada di request
                if (Auth::user()->hasRole('kankemenag')) {
                    $query->where('kab_kota', Auth::user()->kode_institusi);
                }
                $query->where('nsm', '=', $request->nsm);
                $query->where('active', '=', true);

                // Mengurutkan berdasarkan kabupaten/kota, nama, dan kecamatan
                $query->orderBy('kab_kota', 'asc');
                $query->orderBy('nama', 'asc');
                $query->orderBy('kecamatan', 'asc');

                // Ambil data pertama yang cocok dengan filter
                $madrasah = $query->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Mendapatkan Data',
                    'data' => $madrasah,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Mendapatkan Data',
                'errors' => ['Error ' . $th->getMessage()],
            ], 500);
        }
    }
}
