<?php

namespace App\Imports\Data;

use App\Models\MasterMadrasah;
use Maatwebsite\Excel\Concerns\ToModel;

class PrestasiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MasterMadrasah([
            //
        ]);
    }
}
