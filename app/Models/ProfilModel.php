<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilModel extends Model
{
    public function updateAdmin($data) {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
            ]);
    }

    public function updatePassword($data) {
        DB::table('users')
            ->where('email', Auth::user()->email)
            ->update([
                'password' => Hash::make($data['password']),
            ]);
    }

    public function updatePhoto($data) {
        DB::table('users')
            ->where('email', Auth::user()->email)
            ->update([
                'image' => $data['image'],
            ]);
    }

    public function deleteAdmin() {
        DB::table('users')
            ->where('email', Auth::user()->email)
            ->delete();
    }
}
