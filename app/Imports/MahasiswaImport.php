<?php

namespace App\Imports;

use App\Models\MahasiswaModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MahasiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row) {
        return new MahasiswaModel([
            'nim' => $row['NIM'],
            'nama_mhs' => $row['Nama'],
            'kelas_mhs' => $row['Kelas'],
            'prodi_mhs' => $row['Prodi'],
        ]);
    }
}
