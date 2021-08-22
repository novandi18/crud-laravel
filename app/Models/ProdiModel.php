<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ProdiModel extends Model
{
    protected $fillable = [
        'nama_prodi',
        'jml_mhs',
    ];

    protected $table = 'tb_prodi';

    // READ ALL DATA
    public function allData() {
        return DB::table('tb_prodi')->paginate(5);
    }

    // UPDATE JUMLAH MAHASISWA PADA PRODI YANG TELAH DIDAFTARKAN KE DATA MAHASISWA
    public function updateJumlahlMahasiswa($data) {
        DB::table('tb_prodi')
            ->where('nama_prodi', $data['prodi'])
            ->update([
                'jml_mhs' => $data['count']
            ]);
    }

    // READ DATA BY ID
    public function getDataById($id_prodi) {
        return DB::table('tb_prodi')->where('id_prodi', Crypt::decrypt($id_prodi))->get();
    }

    // ADD DATA
    public function addProdi($prodi) {
        DB::table('tb_prodi')->insert($prodi);
    }

    // DELETE DATA
    public function deleteProdi($id_prodi) {
        $getProdi = DB::table('tb_prodi')->where('id_prodi', Crypt::decrypt($id_prodi))->value('nama_prodi');
        DB::table('tb_mahasiswa')->where('prodi_mhs', $getProdi)->delete();
        DB::table('tb_prodi')->where('id_prodi', Crypt::decrypt($id_prodi))->delete();
    }

    // DELETE ALL DATA
    public function deleteAllProdi() {
        DB::table('tb_mahasiswa')->delete();
        DB::table('tb_prodi')->delete();
    }

    // UPDATE DATA
    public function updateProdi($prodi, $id_prodi) {
        $getProdi = DB::table('tb_prodi')->where('id_prodi', Crypt::decrypt($id_prodi))->value('nama_prodi');
        DB::table('tb_mahasiswa')
            ->where('prodi_mhs', $getProdi)
            ->update([
                'prodi_mhs' => $prodi['nama_prodi']
            ]);
            
        DB::table('tb_prodi')
            ->where('id_prodi', Crypt::decrypt($id_prodi))
            ->update([
                'nama_prodi' => $prodi['nama_prodi']
            ]);
    }

    // COUNT ALL DATA PRODI
    public function countAll() {
        return DB::table('tb_prodi')->count();
    }

    // ADD DATA WHERE 'PRODI' IN 'MAHASISWA'
    public function addDataFromMahasiswa($prodi) {
        return DB::table('tb_prodi')->insert($prodi);
    }
}
