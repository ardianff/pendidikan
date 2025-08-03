<?php

namespace App\Imports\Data;

use App\Lib\Helpers;
use App\Models\MasterJenjangMadrasah;
use App\Models\MasterMadrasah;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MadrasahImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $dataMadrasah;
    public $requestData;


    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        try {

            $header = $rows->first();
            $expectedHeader = [
                'nsm',
                'npsn',
                'nama_madrasah',
                'status',
                'kabupaten',
                'kecamatan',
                'alamat',
                'status_konfirmasi',
                'afiliasi_organisasi',
                'jenjang'
            ];

            $actualHeader = $header->keys()->toArray();

            if (array_diff($expectedHeader, $actualHeader)) {
                throw new Exception('Format header tidak sesuai. Pastikan kolom-kolom berikut ada: ' . implode(', ', $expectedHeader));
            }

            $this->dataMadrasah = [];
            foreach ($rows as $row) {
                if (!empty($row)) {
                    try {
                        // Cek jika NSM atau NPSN sudah ada di database
                        $existingMadrasah = MasterMadrasah::where('nsm', $row['nsm'])
                            ->orWhere('npsn', $row['npsn'])
                            ->first();

                        // Jika ditemukan duplikat, tandai dengan status "Duplikat"
                        if ($existingMadrasah) {
                            $this->dataMadrasah[] = [
                                'status' => 'Duplikat',
                                'keterangan' => 'Data Madrasah dengan NSM atau NPSN tersebut sudah ada.',
                                'data' => $row,
                            ];
                        } else {
                            $jateng = '33';
                            $kabKota = Helpers::cekKabKota($jateng, $row['kabupaten']);
                            $kecamatan = Helpers::cekKecamatan($kabKota->kode_kota_kab, $row['kecamatan']);
                            $jenjang = Helpers::cekJenjang($row['jenjang']);
                            $jenjangRequest = MasterJenjangMadrasah::find($this->requestData['jenjang']);
                            if (strtolower($jenjangRequest->nama) != strtolower($row['jenjang'])) {
                                throw new Exception("Jenjang yang dipilih tidak sama dengan data pada dokumen");
                            }
                            $data = [
                                'nsm' => $row['nsm'],
                                'npsn' => $row['npsn'],
                                'nama' => $row['nama_madrasah'],
                                'status' => ucwords($row['status']),
                                'jenjang' => $jenjang->id,
                                'provinsi' => $jateng,
                                'kab_kota' => $kabKota->kode_kota_kab,
                                'kecamatan' => $kecamatan->kode_kecamatan,
                                'kelurahan' => null,
                                'alamat' => $row['alamat'],
                                'konfirmasi' => $row['status_konfirmasi'],
                                'afiliasi_organisasi' => Helpers::cekAfiliasi($row['afiliasi_organisasi']),
                                'active' => true,
                                'isVerif' => true,
                                'alias' => $jenjang->alias,
                            ];

                            // Simpan data ke database
                            MasterMadrasah::create($data);

                            // Menambahkan status "Berhasil"
                            $this->dataMadrasah[] = [
                                'status' => 'Berhasil',
                                'keterangan' => 'Data berhasil disimpan',
                                'data' => $row,
                            ];
                        }
                    } catch (\Throwable $th) {
                        // Tangani kesalahan yang terjadi
                        $this->dataMadrasah[] = [
                            'status' => 'Gagal',
                            'keterangan' => 'Terjadi kesalahan: ' . $th->getMessage(),
                            'data' => $row,
                        ];
                    }
                }
            }
        } catch (\Throwable $th) {
            // Tangani kesalahan besar di seluruh proses
            throw new Exception('Gagal mengimport data. Error : ' . $th->getMessage());
        }
    }
}
