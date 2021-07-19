<?php

namespace App\Exports;

use App\Models\MahasiswaModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MahasiswaExport implements FromView
{
    public function view(): View {
        return view('mahasiswa.export.print', [
            'mahasiswa' => MahasiswaModel::all()
        ]);
    }
}
