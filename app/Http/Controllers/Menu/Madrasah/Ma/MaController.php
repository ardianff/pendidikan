<?php

namespace App\Http\Controllers\Menu\Madrasah\Ma;

use App\Http\Controllers\Controller;
use App\Models\MasterKotaKab;
use App\Models\MasterMadrasah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class MaController extends Controller
{
    public function indexMa(Request $request)
    {
        $kabkota =  MasterKotaKab::where('kode_parent', '=', 33)->get();

        return view(
            'pages.menu.madrasah.ma.index',
            [
                'kabkota' => $kabkota,
            ]
        );
    }
    public function dataMa(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterMadrasah::with([
                'dt_provinsi',
                'dt_kotakab',
                'dt_kecamatan',
                'dt_keldesa',
                'dt_jenjang',
                'dt_afiliasi'
            ])
                ->where('jenjang', 4)
                ->where('active', 1);

            if ($request->kab_kota && $request->kab_kota !== 'semua') {
                $query->where('kab_kota', $request->kab_kota);
            } elseif (Auth::user()->hasRole('kankemenag')) {
                // untuk kankemenag, kunci ke kode_instansi mereka
                $query->where('kab_kota', Auth::user()->kode_institusi);
            }

            // Filter Status
            if ($request->status && $request->status !== 'semua') {
                $query->where('status', $request->status);
            }
            $query->orderBy('kab_kota', 'asc');
            $query->orderBy('nama', 'asc');
            $query->orderBy('kecamatan', 'asc');
            // $data = $query->get();
            return DataTables::of($query)
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
                                   data-value="' . $nsm . '"
                                   >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </li>
                            <li class="delete">
                                <a href="#"
                                id="btn-delete"

                                   data-id="' . $encryptedId . '"
                                   data-jenis="' . $nama . '"
                                   data-value="' . $nsm . '"
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
    }
}
