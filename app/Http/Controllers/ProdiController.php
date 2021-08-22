<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use Illuminate\Http\Request;
use App\Models\ProdiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdiExport;

class ProdiController extends Controller
{
    public function __construct() {
        $this->ProdiModel = new ProdiModel();
    }

    // READ DATA
    public function index() {
        $prodi = $this->ProdiModel->allData();
        $total = DB::table('tb_prodi')->count();
        if($total > 0) {
            $noData = false;
        } else {
            $noData = true;
        }

        // CEK APAKAH JUMLAH MAHASISWA PADA PRODI SAMA DENGAN PRODI YANG DIPILIH PADA DATA MAHASISWA
        foreach ($prodi as $p) {
            $x = DB::table('tb_mahasiswa')->where('prodi_mhs', $p->nama_prodi)->count();
            if($p->jml_mhs != $x) {
                $this->ProdiModel->updateJumlahlMahasiswa(['count' => $x, 'prodi' => $p->nama_prodi]);
            }
        }
        
        $data = [
            'prodi' => $prodi,
            'title' => 'Prodi',
            'nodata' => $noData
        ];

        return view('prodi', $data);
    }

    // ADD DATA
    public function add() {
        $data = [
            'title' => 'Tambah Data Prodi'
        ];

        return view('prodi.tambah', $data);
    }

    public function addProcess() {
        Request()->validate([
            'nama_prodi' => 'required|unique:tb_prodi,nama_prodi'
        ], [
            'nama_prodi.required' => 'Nama prodi harus diisi.',
            'nama_prodi.unique' => 'Nama prodi sudah ada.'
        ]);

        $prodi = [
            'nama_prodi' => Request()->nama_prodi,
            'jml_mhs' => 0,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ];

        $this->ProdiModel->addProdi($prodi);
        return redirect()->route('prodi')->with('pesan', 'Data berhasil ditambahkan');
    }
    
    // DELETE DATA
    public function delete($id_prodi) {
        $this->ProdiModel->deleteProdi($id_prodi);
        return redirect()->route('prodi')->with('pesan', 'Data berhasil dihapus');
    }
    
    // DELETE ALL DATA
    public function deleteAll() {
        $this->ProdiModel->deleteAllProdi();
        return redirect()->route('prodi')->with('pesan', 'Data prodi dan mahasiswa berhasil dihapus semua');
    }

    // UPDATE DATA
    public function update($id_prodi) {
        $data = [
            'prodi' => $this->ProdiModel->getDataById($id_prodi),
            'title' => 'Edit Data Prodi'
        ];

        return view('prodi.edit', $data);
    }

    public function updateProcess($id_prodi) {
        Request()->validate([
            'nama_prodi' => 'required|unique:tb_prodi,nama_prodi'
        ], [
            'nama_prodi.required' => 'Nama Prodi harus diisi',
            'nama_prodi.unique' => 'Nama prodi sudah ada.'
        ]);
        
        $prodi = [
            'nama_prodi' => Request()->nama_prodi
        ];

        $newProdi = DB::table('tb_prodi')->where('id_prodi', Crypt::decrypt($id_prodi))->value('nama_prodi');
        $this->ProdiModel->updateProdi($prodi, $id_prodi);
        return redirect()->route('prodi')->with('pesan', 'Data Prodi berhasil diubah dari <b>' . $newProdi . '</b> menjadi <b>' . Request()->nama_prodi . '</b>.');
    }

    // SEARCH DATA
    public function search() {
        Request()->validate([
            'search' => 'required'
        ]);
        
        DB::enableQueryLog();
        $result = DB::table('tb_prodi')
            ->where('nama_prodi', 'LIKE', "%".Request()->search."%")
            ->orWhere('jml_mhs', 'LIKE', "%".Request()->search."%")
            ->get();

        $queries = DB::getQueryLog();

        $data = [
            'search' => Request()->search,
            'result' => $result,
            'title' => 'Hasil Pencarian Data Prodi',
            'log' => $queries[0]["time"]
        ];

        return view('prodi.search', $data);
    }

    // IMPORT DATA
    public function import() {
        $data = [
            'title' => 'Import Data Prodi'
        ];

        return view('prodi.import', $data);
    }

    public function importProcess(Request $request) {
        $request->validate([
            'excel' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel'
        ], [
            'excel.required' => 'File harus diupload',
            'excel.mimes' => 'Tipe file harus excel!'
        ]);

        Excel::import(new ProdiImport, $request->file('excel'));
        return redirect()->route('prodi')->with('pesan', 'Import data prodi berhasil');
    }

    // EXPORT DATA
    public function export() {
        return Excel::download(new ProdiExport, 'data_prodi_'.date('dmY').'.xlsx');
    }
}