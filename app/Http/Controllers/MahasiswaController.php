<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\matches;

class MahasiswaController extends Controller
{
    public function __construct() {
        $this->MahasiswaModel = new MahasiswaModel();
        $this->ProdiModel = new ProdiModel();
    }

    // READ ALL DATA
    public function index() {
        $mhs = $this->MahasiswaModel->allData();
        $mhsUnique = $mhs->unique('kelas_mhs');
        $total = DB::table('tb_mahasiswa')->count();
        if($total > 0) {
            $noData = false;
        } else {
            $noData = true;
        }

        $data = [
            'mahasiswa' => $this->MahasiswaModel->allData(),
            'prodi' => $this->ProdiModel->allData(),
            'kelas' => $mhsUnique->values()->all(),
            'title' => 'Mahasiswa',
            'data' => $noData
        ];

        return view('home', $data);
    }

    // ADD DATA
    public function add() {
        $mhs = $this->ProdiModel->allData();
        $countProdi = DB::table('tb_prodi')->count();
        if($countProdi > 0) {
            $noProdi = false;
        } else {
            $noProdi = true;
        }

        $data = [
            'prodi' => $mhs,
            'title' => 'Tambah Data Mahasiswa',
            'noprodi' => $noProdi
        ];

        return view('mahasiswa.tambah', $data);
    }

    public function addProcess() {
        Request()->validate([
            'nim'       => 'required|unique:tb_mahasiswa,nim|max:10',
            'nama_mhs'  => 'required|max:256',
            'kelas_mhs' => 'required|max:3',
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.max'      => 'NIM tidak diizinkan lebih dari 10 angka',
            'nim.unique'   => 'NIM ini sudah ada.',
            'nama_mhs.required' => 'Nama mahasiswa harus diisi.',
            'nama_mhs.max'      => 'Nama mahasiswa terlalu panjang',
            'kelas_mhs.required' => 'Kelas mahasiswa harus diisi.',
            'kelas_mhs.max'      => 'Kelas mahasiswa tidak diizinkan lebih dari 3 karakter'
        ]);

        $mhs = [
            'nim' => Request()->nim,
            'nama_mhs' => Request()->nama_mhs,
            'kelas_mhs' => Request()->kelas_mhs,
            'prodi_mhs' => Request()->prodi_mhs,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ];

        $prodi = [
            'nama_prodi' => Request()->prodi_mhs
        ];

        $this->MahasiswaModel->addMahasiswa($mhs, $prodi);
        return redirect()->route('mahasiswa')->with('pesan', 'Data berhasil ditambahkan');
    }

    // DELETE DATA
    public function delete($id_mhs) {
        $this->MahasiswaModel->deleteMahasiswa($id_mhs);
        return redirect()->route('mahasiswa')->with('pesan', 'Data berhasil dihapus');
    }

    // UPDATE DATA
    public function update($id_mhs) {
        $getData = $this->MahasiswaModel->getDataById($id_mhs);
        
        $data = [
            'mahasiswa' => $getData,
            'prodi' => $this->ProdiModel->allData(),
            'title' => 'Edit Data Mahasiswa'
        ];

        return view('mahasiswa.edit', $data);
    }

    public function updateProcess($id_mhs) {
        Request()->validate([
            'nim' => [
                'required',
                'max:11',
                function($attr, $val, $fail) {
                    if($val < 0) {
                        $fail('NIM harus bernilai positif');
                    }
                }
            ],
            'nama_mhs' => 'required|max:256|regex:/0-9/',
            'kelas_mhs' => 'required|max:3',
        ], [
            'nim.required' => 'NIM mahasiswa harus diisi.',
            'nim.max' => 'NIM mahasiswa maksimal 11 angka.',
            'nama_mhs.required' => 'Nama mahasiswa harus diisi.',
            'nama_mhs.max'      => 'Nama mahasiswa terlalu panjang',
            'nama_mhs.regex'      => 'Nama mahasiswa harus berupa huruf',
            'kelas_mhs.required' => 'Kelas mahasiswa harus diisi.',
            'kelas_mhs.max'      => 'Kelas mahasiswa tidak diizinkan lebih dari 3 karakter'
        ]);

        $mhs = [
            'nim' => Request()->nim,
            'nama_mhs' => Request()->nama_mhs,
            'kelas_mhs' => Request()->kelas_mhs,
            'prodi_mhs' => Request()->prodi_mhs
        ];

        $this->MahasiswaModel->updateMahasiswa($mhs, $id_mhs);
        return redirect()->route('mahasiswa')->with('pesan', 'Data berhasil diubah');
    }

    // SEARCH DATA
    public function search() {
        Request()->validate([
            'search' => 'required'
        ]);

        DB::enableQueryLog();
        if(Request()->kelas != '' && Request()->prodi != '') {
            $result = DB::table('tb_mahasiswa')
                        ->where(function($check) {
                            $check->where('nim', 'LIKE', '%'.Request()->search.'%')
                                ->orWhere('nama_mhs', 'LIKE', '%'.Request()->search.'%');
                        })
                        ->where('kelas_mhs', '=', Request()->kelas)
                        ->where('prodi_mhs', '=', Request()->prodi)
                        ->get();
        } else if(Request()->kelas != '' && Request()->prodi == '') {
            $result = DB::table('tb_mahasiswa')
                        ->where(function($check) {
                            $check->where('nim', 'LIKE', '%'.Request()->search.'%')
                                ->orWhere('nama_mhs', 'LIKE', '%'.Request()->search.'%');
                        })
                        ->where('kelas_mhs', '=', Request()->kelas)
                        ->get();
        } else if(Request()->kelas == '' && Request()->prodi != '') {
            $result = DB::table('tb_mahasiswa')
                        ->where(function($check) {
                            $check->where('nim', 'LIKE', '%'.Request()->search.'%')
                                ->orWhere('nama_mhs', 'LIKE', '%'.Request()->search.'%');
                        })
                        ->where('prodi_mhs', '=', Request()->prodi)
                        ->get();
                        
        } else {
            $result = DB::table('tb_mahasiswa')
                        ->where('nim', 'LIKE', '%'.Request()->search.'%')
                        ->orWhere('nama_mhs', 'LIKE', '%'.Request()->search.'%')
                        ->get();
        }

        $queries = DB::getQueryLog();
        $mhs = $this->MahasiswaModel->allData();
        $mhsUnique = $mhs->unique('kelas_mhs');

        $data = [
            'search' => Request()->search,
            'kelas_s' => Request()->kelas,
            'prodi_s' => Request()->prodi,
            'kelas' => $mhsUnique->values()->all(),
            'prodi' => $this->ProdiModel->allData(),
            'result' => $result,
            'title' => 'Hasil Pencarian Data Mahasiswa',
            'log' => $queries[0]["time"]
        ];

        return view('mahasiswa.search', $data);
    }

    // PRINT DATA
    public function print() {
        $data = [
            'mahasiswa' => $this->MahasiswaModel->allData(),
            'title' => 'Data Mahasiswa Tahun '. date('Y') .'/'. date('Y') + 1,
            'date' => 'Tahun Ajaran ' . date('Y') .'/'. date('Y') + 1
        ];

        $pdf = PDF::loadView('mahasiswa/print', $data);
        return $pdf->stream();
    }

    // IMPORT DATA
    public function import() {
        $data = [
            'title' => 'Import Data Mahasiswa'
        ];

        return view('mahasiswa.import', $data);
    }

    public function importProcess(Request $request) {
        $request->validate([
            'excel' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel'
        ], [
            'excel.required' => 'File harus diupload',
            'excel.mimes' => 'Tipe file harus excel!',
        ]);

        Excel::import(new MahasiswaImport, $request->file('excel'));
        $countProdi = $this->ProdiModel->countAll();
        if($countProdi < 1) {
            $prodiUnique = $this->MahasiswaModel->selectUniqueProdi();
            foreach ($prodiUnique as $v) {
                $prodi[] = [
                    'nama_prodi' => $v->prodi_mhs,
                    'jml_mhs' => 0,
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }
            $this->ProdiModel->addDataFromMahasiswa($prodi);
            $prodi = $this->ProdiModel->allData();
            foreach ($prodi as $p) {
                $x = DB::table('tb_mahasiswa')->where('prodi_mhs', $p->nama_prodi)->count();
                if($p->jml_mhs != $x) {
                    $this->ProdiModel->updateJumlahlMahasiswa(['count' => $x, 'prodi' => $p->nama_prodi]);
                }
            }
            return redirect()->route('mahasiswa')->with('pesan', 'Import data mahasiswa berhasil');
        }
        return redirect()->route('mahasiswa')->with('pesan', 'Import data mahasiswa berhasil');
    }

    // EXPORT DATA
    public function export() {
        return Excel::download(new MahasiswaExport, 'data_mahasiswa_'.date('dmY').'.xlsx');
    }

    // HAPUS SEMUA DATA
    public function deleteAll(Request $request) {
        if($request->deleteProdi) {
            $this->ProdiModel->deleteAllProdi();
        }

        $this->MahasiswaModel->deleteAllData();
        return redirect()->route('mahasiswa')->with('pesan', 'Berhasil menghapus semua data mahasiswa');
    }
}
