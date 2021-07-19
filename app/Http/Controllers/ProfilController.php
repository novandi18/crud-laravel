<?php

namespace App\Http\Controllers;

use App\Models\ProfilModel;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
// use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;

class ProfilController extends Controller
{
    public function __construct() {
        $this->ProfilModel = new ProfilModel();
    }

    public function index() {
        $data = [
            'title' => 'Profil Admin'
        ];

        return view('profil.admin', $data);
    }
    
    // EDIT PROFIL FORM ADMIN
    public function edit() {
        if(Cache::has('verify')) {
            $data = [
                'title' => 'Edit Admin'
            ];
        
            return view('profil.edit', $data);
        }
        
        return redirect()->route('verify_form', ['form' => 'edit_profil']);
    }

    public function editProcess() {
        if(Request()->username == Auth::user()->username || Request()->email == Auth::user()->email) {
            Request()->validate([
                'name' => 'required',
                'username' => 'required|min:5',
                'email' => 'required|email'
            ], [
                'name.required' => 'Nama harus diisi',
                'username.required' => 'Username harus diisi',
                'username.min' => 'Username harus minimal 5 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
            ]);
        } else {
            Request()->validate([
                'name' => 'required',
                'username' => 'required|min:5|unique:users,username',
                'email' => 'required|email|unique:users,email'
            ], [
                'name.required' => 'Nama harus diisi',
                'username.required' => 'Username harus diisi',
                'username.min' => 'Username harus minimal 5 karakter',
                'username.unique' => 'Username sudah terdaftar',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
            ]);
        }
        
        $data = [
            'name' => Request()->name,
            'username' => Request()->username,
            'email' => Request()->email,
        ];

        $this->ProfilModel->updateAdmin($data);
        return redirect()->route('profil')->with('pesan', 'Edit data admin berhasil.');
    }
    
    // VERIFIKASI FORM PASSWORD ADMIN
    public function verifyForm($form) {
        $data = [
            'title' => 'Verifikasi Admin',
            'form' => $form
        ];
    
        return view('profil.verify', $data);
    }

    // VERIFIKASI PASSWORD ADMIN
    public function verifyPassword() {
        Request()->validate([
            'password' => 'required|string|min:8'
        ], [
            'password.required' => 'Password harus diisi',
            'password.string' => 'Password harus String',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $check = Hash::check(Request()->password, Auth::user()->password);

        if($check == true) {
            // Verifikasi Password akan dapat tetap dilewati selama 5 menit
            Cache::put('verify', true, 300);
            return redirect()->route(Request()->form);
        } else {
            return redirect()->route('verify_form', ['form' => Request()->form])->with('pesan', 'Password tidak cocok');
        }
    }

    // UBAH PASSWORD ADMIN
    public function changePassword() {
        if(Cache::has('verify')) {
            $data = [
                'title' => 'Edit Password Admin'
            ];
        
            return view('profil.changepassword', $data);
        }
        
        return redirect()->route('verify_form', ['form' => 'edit_password']);
    }

    public function changePasswordProcess() {
        Request()->validate([
            'password' => 'required|min:8',
            'password2' => 'required|min:8'
        ], [
            'password.required' => 'Password lama harus diisi',
            'password.min' => 'Password lama harus berisikan minimal 8 karakter',
            'password2.required' => 'Password baru harus diisi',
            'password2.min' => 'Password baru harus berisikan minimal 8 karakter'
        ]);

        $checkPass = Hash::check(Request()->password, Auth::user()->password);
        if($checkPass == false) {
            return redirect()->route('edit_password')->with('pesan', 'Password lama tidak cocok dengan password pada akun ini');
        }

        $updatePassword = DB::table('users')->where(['email' => Auth::user()->email])->first();

        if(!$updatePassword){
            return redirect()->route('edit_password')->with('pesan', 'Email admin tidak valid');
        }

        $this->ProfilModel->updatePassword(['password' => Request()->password2]);
        return redirect()->route('profil')->with('pesan', 'Edit password admin berhasil.');
    }

    // UBAH FOTO PROFIL ADMIN
    public function changePhoto() {
        if(Cache::has('verify')) {
            $data = [
                'title' => 'Edit Foto Admin'
            ];
        
            return view('profil.photo', $data);
        }
        
        return redirect()->route('verify_form', ['form' => 'edit_photo']);
    }

    public function changePhotoProcess() {
        Request()->validate([
            'image' => 'required|max:2048',
        ], [
            'image.required' => 'Gambar harus diupload',
            'image.max' => 'Gambar maksimal harus berukuran 2048KB atau 2MB'
        ]);

        if(Request()->image_c == '') {
            return redirect()->route('edit_photo')->with('pesan', 'Gagal mengubah foto profil, mohon untuk melakukannya beberapa saat lagi');
        }

        $path = public_path('img/admin/');
        $img_parts = explode(";base64,", Request()->image_c);
        // $img_type_aux = explode("img/", $img_parts[0]);
        // $img_type = $img_type_aux[1];
        $img_base64 = base64_decode($img_parts[1]);

        $imgName = Auth::user()->username . '.png';
        $imgFullPath = $path.$imgName;

        file_put_contents($imgFullPath, $img_base64);
        $this->ProfilModel->updatePhoto(['image' => 'img/admin/'.$imgName]);
        return redirect()->route('profil')->with('pesan', 'Edit foto admin berhasil.');
    }

    // HAPUS AKUN ADMIN
    public function removeAdmin() {
        return redirect()->route('verify_form', ['form' => 'delete_admin']);
    }

    public function verifyForDelete(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        if($request->email != Auth::user()->email) {
            return back()->with('pesan', 'Email tidak sama dengan email akun pada session ini.');
        }

        $token = Str::random(64);

        Mail::send('profil.mail', ['token' => $token], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Email Verification');
        });

        return redirect()->route('verify_form', ['form' => 'delete_admin'])->with('success', 'Verifikasi Email berhasil dikirim.');
    }

    public function removeAdminConfirm($token) {
        $data = [
            'token' => $token,
            'title' => 'Delete Admin'
        ];

        return view('profil.remove', $data);
    }

    public function removeAdminProcess($token) {
        if(!$token) {
            $data = [
                'title' => 'Profil Admin'
            ];

            return redirect()->route('profil', $data);
        }

        $this->ProfilModel->deleteAdmin();
        unlink("img/admin/".Auth::user()->username.".png");
        Auth::logout();
        Cache::flush();
        return redirect()->route('login');
    }
}
