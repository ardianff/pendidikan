<?php

namespace App\Http\Controllers\Menu\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Import\Madrasah\StoreImportMadrasahRequest;
use App\Imports\Data\MadrasahImport;
use App\Models\MasterJenjangMadrasah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportMadrasahController extends Controller
{
    public function indexImportMadrasah(Request $request)
    {
        $jenjang = MasterJenjangMadrasah::where('active', '=', true)->select('nama', 'id', 'active')->get();
        return view('pages.menu.import.madrasah.index', [
            'jenjang' => $jenjang
        ]);
    }
    public function storeImportMadrasah(StoreImportMadrasahRequest $request)
    {
        try {
            if ($request->ajax() && $request->validated()) {
                if ($request->hasFile('file_dokumen')) {
                    $dataRequest = $request->all();
                    $import = new MadrasahImport($dataRequest);
                    $file = $request->file('file_dokumen');
                    Excel::import($import, $file);
                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil memproses data',
                        'data' => $import->dataMadrasah,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'errors' => [
                    'Error : ' . $th->getMessage() . ' ' . $th->getFile()
                ],
            ], 500);
        }
    }
}
