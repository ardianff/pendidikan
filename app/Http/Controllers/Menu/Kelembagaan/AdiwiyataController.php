<?php

namespace App\Http\Controllers\Menu\Kelembagaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Kelembagaan\Adiwiyata\StoreMadrasahAdiwiyataRequest;
use App\Lib\Helpers;
use App\Models\MasterJenjangMadrasah;
use App\Models\MasterMadrasah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AdiwiyataController extends Controller
{
    public function indexAdiwiyata()
    {
        $jenjang = MasterJenjangMadrasah::where('active', '=', true)->get();
        return view(
            'pages.menu.kelembagaan.adiwiyata.index',
            [

                'jenjang' => $jenjang,
            ]
        );
    }
    public function dataMadrasahAdiwiyata(Request $request)
    {
        try {
            if ($request->ajax()) {
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

                $madrasah = $query->get();
                return DataTables::of($madrasah)
                    ->addColumn('action', function ($item) {
                        // encrypt id
                        $encryptedId = Crypt::encryptString($item->id);
                        $nama    = e($item->nama);
                        $nsm    = e($item->nsm);

                        return '
                            <ul class="action">
                                <li class="edit">
                                    <a href="#"
                                    id="btn-edit"
                                    data-id="' . $encryptedId . '"
                                    data-nama="' . $nama . '"
                                    data-nsm="' . $nsm . '"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </li>
                                <li class="delete">
                                    <a href="#"
                                    id="btn-delete"

                                    data-id="' . $encryptedId . '"
                                    data-nama="' . $nama . '"
                                    data-nsm="' . $nsm . '"
                                    >
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </li>
                            </ul>
                        ';
                    })
                    ->editColumn('id', function ($item) {
                        return Crypt::encryptString($item->id);
                    })
                    ->rawColumns(['action', 'waktu'])
                    ->make(true);
            }

            // kalau bukan AJAX, bisa kembalikan view atau abort
            return abort(404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data',
                'errors'  => ['Error: ' . $th->getMessage()],
            ], 500);
        }
    }
    public function storeMadrasahAdiwiyata(StoreMadrasahAdiwiyataRequest $request)
    {
        try {
            if ($request->validated() && $request->ajax()) {

                dd($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Data Madrasah Adiwiyata berhasil disimpan',
                ], 200);
            }
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menyimpan Data',
                'errors' => ['Error ' . $th->getMessage()],
            ], 500);
        }
    }
}
