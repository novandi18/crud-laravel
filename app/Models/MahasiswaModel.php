<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class MahasiswaModel extends Model
{
    protected $fillable = [
        'nim',
        'nama_mhs',
        'kelas_mhs',
        'kelas_mhs',
        'prodi_mhs',
    ];

    protected $table = 'tb_mahasiswa';

    // READ ALL DATA
    public function allData() {
        return DB::table('tb_mahasiswa')->paginate(5);
    }

    // READ DATA BY ID
    public function getDataById($id_mhs) {
        return DB::table('tb_mahasiswa')->where('id_mhs', Crypt::decrypt($id_mhs))->get();
    }

    // ADD DATA
    public function addMahasiswa($mhs, $prodi) {
        DB::table('tb_mahasiswa')->insert($mhs);
        DB::table('tb_prodi')
            ->where('nama_prodi', $prodi)
            ->increment('jml_mhs', 1);
    }

    // DELETE DATA
    public function deleteMahasiswa($id_mhs) {
        $prodi = DB::table('tb_mahasiswa')->where('id_mhs', Crypt::decrypt($id_mhs))->value('prodi_mhs');
        DB::table('tb_prodi')
        ->where('nama_prodi', $prodi)
        ->decrement('jml_mhs', 1);

        DB::table('tb_mahasiswa')->where('id_mhs', Crypt::decrypt($id_mhs))->delete();
    }

    // UPDATE DATA
    public function updateMahasiswa($data, $id_mhs) {
        DB::table('tb_mahasiswa')
            ->where('id_mhs', Crypt::decrypt($id_mhs))
            ->update([
                'nama_mhs' => $data['nama_mhs'],
                'kelas_mhs' => $data['kelas_mhs'],
                'prodi_mhs' => $data['prodi_mhs'],
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now()
            ]);
    }

    // DELETE ALL DATA
    public function deleteAllData() {
        return DB::table('tb_mahasiswa')->delete();
    }

    public function selectUniqueProdi() {
        return DB::table('tb_mahasiswa')->select('prodi_mhs')->distinct()->get();
    }
}
