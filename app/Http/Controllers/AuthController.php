<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function index() {
        return redirect()->route('login');
    }

    // LOGIN
    public function login() {
        if(Auth::check()) {
            return redirect()->route('mahasiswa');
        }

        $count = DB::table('users')->count();
        if($count > 0) {
            $noUser = false;
        } else {
            $noUser = true;
        }

        $data = [
            'nodata' => $noUser,
            'message' => false,
            'title' => 'Login'
        ];
        return view('auth.login', $data);
    }

    public function loginProcess() {
        Request()->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa String',
            'password.required' => 'Password harus diisi',
            'password.string' => 'Password harus berupa String'
        ]);

        $getPassByUsername = DB::table('users')->where('username', Request()-> username)->value('password');
        $checkPassword = Hash::check(Request()->password, $getPassByUsername);
        if($checkPassword == false) {
            return redirect()->route('login')->with('fail', 'Username atau Password tidak ditemukan');
        }

        $data = [
            'username' => Request()->username,
            'password' => Request()->password
        ];

        Auth::attempt($data);
        return redirect()->route('mahasiswa');
    }

    // REGISTER
    public function register() {
        if(Auth::check()) {
            return redirect()->route('mahasiswa');
        }
        
        $data = [
            'title' => 'Register',
            'message' => false
        ];
        return view('auth.register', $data);
    }

    public function registerProcess() {
        Request()->validate([
            'name' => 'required',
            'username' => 'required|min:5|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username harus minimal 5 karakter',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus minimal 8 karakter',
            'password.comfirmed' => 'Password tidak sama dengan konfirmasi password'
        ]);

        $user = new User;
        $user->uuid = $this->attributes['uuid'] = Uuid::uuid4()->toString();
        $user->name = Request()->name;
        $user->username = Request()->username;
        $user->email = strtolower(Request()->email);
        $user->password = Hash::make(Request()->password);
        $user->image = "img/default.png";
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();

        if($simpan) {
            $data = [
                'message' => true,
                'title' => 'Login',
                'success' => 'Register berhasil, silahkan login.',
                'nodata' => false
            ];

            return view('auth.login', $data);
        } else {
            $data = [
                'message' => true,
                'title' => 'Register',
                'failed' => 'Register gagal, mohon ulangi beberapa saat lagi.'
            ];

            return view('auth.register', $data);
        }
    }

    // FORGOT PASSWORD
    public function forgotPassword() {
        if(Auth::check()) {
            return redirect()->route('mahasiswa');
        }

        $data = [
            'title' => 'Forgot Password',
            'message' => false
        ];
        return view('auth.forgotpassword', $data);
    }
    
    // LOGOUT
    public function logout() {
        Auth::logout(); // Menghapus session yang aktif
        Cache::flush(); // Menghapus semua cache yang ada
        return redirect()->route('login');
    }
    
    // VERIFY EMAIL
    public function verifyEmail() {
        if(Auth::check()) {
            return redirect()->route('mahasiswa');
        }
        
        $data = [
            'title' => 'Verifikasi Email',
            'message' => false,
        ];
        return view('auth.forgotpassword', $data);
    }

    public function verifyRequest(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email harus disertakan',
            'email.email' => 'Format email tidak valid'
        ]);

        if(User::where('email', $request->email)->first() == null) {
            return redirect()->route('forgot')->with('pesan', 'Email tidak terdaftar');
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }

    // RESET PASSWORD
    public function resetPassword() {
        if(Auth::check()) {
            return redirect()->route('mahasiswa');
        }
        
        $data = [
            'title' => 'Reset Password',
            'message' => false
        ];
        return view('auth.reset', $data);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password2' => 'required|min:8|same:password'
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password2.same' => 'Password tidak sama',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password2', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
