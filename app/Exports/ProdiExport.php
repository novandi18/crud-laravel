<?php

namespace App\Exports;

use App\Models\ProdiModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProdiExport implements FromView
{
    public function view(): View {
        return view('prodi.export.print', [
            'prodi' => ProdiModel::all()
        ]);
    }
}
