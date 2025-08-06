<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMadrasah extends Model
{
    use SoftDeletes, HasUuids;


    protected $guarded = ['uuid'];


    public function dt_provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi', 'kode_provinsi');
    }
    public function dt_kotakab()
    {
        return $this->belongsTo(MasterKotaKab::class, 'kab_kota', 'kode_kota_kab');
    }
    public function dt_kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan', 'kode_kecamatan');
    }

    public function dt_keldesa()
    {
        return $this->belongsTo(MasterKelurahan::class, 'kelurahan', 'kode_kelurahan');
    }
    public function dt_jenjang()
    {
        return $this->belongsTo(MasterJenjangMadrasah::class, 'jenjang', 'id');
    }
    public function dt_afiliasi()
    {
        return $this->belongsTo(MasterOrganisasi::class, 'afiliasi_organisasi', 'id');
    }
}
