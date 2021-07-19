<?php

namespace App\Imports;

use App\Models\ProdiModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProdiImport implements ToModel, WithHeadingRow
{    
    public function model(array $row) {
        return new ProdiModel([
            'nama_prodi' => $row['Nama Prodi'],
            'jml_mhs' => $row['Jumlah Mahasiswa'],
        ]);
    }
}
