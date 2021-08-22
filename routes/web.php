<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// AUTH
Route::get('/admin', [
    AuthController::class, 'index'
]);

// LOGIN
Route::get('/admin/login', [
    AuthController::class, 'login'
])->name('login');

Route::post('/admin/login', [
    AuthController::class, 'loginProcess'
])->name('login');

// REGISTER
Route::get('/admin/register', [
    AuthController::class, 'register'
])->name('register');

Route::post('/admin/register', [
    AuthController::class, 'registerProcess'
])->name('register');

// FORGOT PASSWORD
Route::get('/admin/forgotpassword', [
    AuthController::class, 'forgotPassword'
])->name('forgot');

Route::post('/admin/forgotpassword', [
    AuthController::class, 'forgotPasswordProcess'
])->name('forgot');

// VEFIFY EMAIL TO CHANGE PASSWORD
Route::get('/admin/forgotpassword/verify', [
    AuthController::class, 'verifyEmail'
])->name('verify_email');

Route::post('/admin/forgotpassword/verify', [
    AuthController::class, 'verifyRequest'
])->name('send_verify');

Route::get('/admin/forgotpassword/{token}', function($token) {
    return view('auth.reset', ['token' => $token, 'title' => 'Reset Password']);
})->name('password.reset');

Route::post('/admin/forgotpassword/update', [
    AuthController::class, 'updatePassword'
])->name('password_reset');

// FORM RESET PASSWORD
Route::get('/admin/forgotpassword/reset', [
    AuthController::class, 'resetPassword'
])->name('reset_password');

// MIDDLEWARE
Route::group(['middleware' => 'auth'], function() {    
    // Mahasiswa
    Route::get('/', [
        MahasiswaController::class, 'index'
    ])->name('mahasiswa');
    
    // ADD Mahasiswa
    Route::get('/mahasiswa/tambah', [
        MahasiswaController::class, 'add'
    ]);
    
    Route::post('/mahasiswa/tambah/process', [
        MahasiswaController::class, 'addProcess'
    ]);
    
    // UPDATE Mahasiswa
    Route::get('/mahasiswa/update/{id_mhs}', [
        MahasiswaController::class, 'update'
    ]);
    
    Route::post('/mahasiswa/update/process/{id_mhs}', [
        MahasiswaController::class, 'updateProcess'
    ]);
    
    // DELETE Mahasiswa
    Route::get('/mahasiswa/hapus/{id_mhs}', [
        MahasiswaController::class, 'delete'
    ]);
    
    // SEARCH Mahasiswa
    Route::get('/mahasiswa/search', [
        MahasiswaController::class, 'search'
    ]);
    
    // PRINT Mahasiswa
    Route::get('/mahasiswa/print', [
        MahasiswaController::class, 'print'
    ]);
    
    // Prodi
    Route::get('/prodi', [
        ProdiController::class, 'index'
    ])->name('prodi');
    
    // ADD Prodi
    Route::get('/prodi/tambah', [
        ProdiController::class, 'add'
    ]);
    
    Route::post('/prodi/tambah/process', [
        ProdiController::class, 'addProcess'
    ]);
    
    // DELETE Prodi
    Route::get('/prodi/delete/{id_prodi}', [
        ProdiController::class, 'delete'
    ]);
    
    // DELETE ALL Prodi
    Route::get('/prodi/deleteall', [
        ProdiController::class, 'deleteAll'
    ])->name("delete_prodi");
    
    // UPDATE Prodi
    Route::get('/prodi/update/{id_prodi}', [
        ProdiController::class, 'update'
    ]);
    
    Route::post('/prodi/update/process/{id_prodi}', [
        ProdiController::class, 'updateProcess'
    ]);
    
    // SEARCH Prodi
    Route::get('/prodi/search', [
        ProdiController::class, 'search'
    ]);

    // PROFIL ADMIN
    Route::get('/admin/profil', [
        ProfilController::class, 'index'
    ])->name('profil');

    // EDIT ADMIN
    Route::get('/admin/profil/edit', [
        ProfilController::class, 'edit'
    ])->name('edit_profil');

    // EDIT ADMIN PROCESS
    Route::post('/admin/profil/edit', [
        ProfilController::class, 'editProcess'
    ])->name('edit_process');

    // VERIFY PASSWORD FORM ADMIN
    Route::get('/admin/profil/{form}/verify/', [
        ProfilController::class, 'verifyForm'
    ])->name('verify_form');

    // VERIFY PASSWORD ADMIN
    Route::post('/admin/profil/{form}/verify', [
        ProfilController::class, 'verifyPassword'
    ])->name('verify_password');

    // CHANGE PHOTO ADMIN
    Route::get('/admin/profil/edit_photo', [
        ProfilController::class, 'changePhoto'
    ])->name('edit_photo');
        
    // CHANGE PHOTO ADMIN PROCESS
    Route::post('/admin/profil/edit_photo', [
        ProfilController::class, 'changePhotoProcess'
    ])->name('edit_photo_process');

    // CHANGE PASSWORD ADMIN
    Route::get('/admin/profil/edit_password', [
        ProfilController::class, 'changePassword'
    ])->name('edit_password');

    // CHANGE PASSWORD ADMIN PROCESS
    Route::post('/admin/profil/edit_password', [
        ProfilController::class, 'changePasswordProcess'
    ])->name('edit_pass_process');

    // DELETE ADMIN
    Route::get('/admin/profil/delete_admin', [
        ProfilController::class, 'removeAdmin'
    ])->name('delete_admin');

    // VERIFY EMAIL FOR DELETE ADMIN
    Route::post('/admin/profil/delete_admin', [
        ProfilController::class, 'verifyForDelete'
    ])->name('verify_delete');

    // DELETE ADMIN CONFIRM
    Route::get('/admin/profil/delete_admin/{token}', [
        ProfilController::class, 'removeAdminConfirm'
    ])->name('delete_admin_confirm');

    // DELETE ADMIN CONFIRM PROCESS
    Route::get('/admin/profil/delete_admin/{token}/confirm', [
        ProfilController::class, 'removeAdminProcess'
    ])->name('delete_admin_process');

    // LOGOUT
    Route::get('/logout', [
        AuthController::class, 'logout'
    ])->name('logout');

    // IMPORT EXCEL PRODI
    Route::get('/prodi/import', [
        ProdiController::class, 'import'
    ])->name('import_prodi');

    Route::post('/prodi/import', [
        ProdiController::class, 'importProcess'
    ])->name('import_prodi_process');

    // EXPORT EXCEL PRODI
    Route::get('/prodi/export', [
        ProdiController::class, 'export'
    ])->name('export_prodi');

    // IMPORT EXCEL MAHASISWA
    Route::get('/mahasiswa/import', [
        MahasiswaController::class, 'import'
    ])->name('import_mahasiswa');

    Route::post('/mahasiswa/import', [
        MahasiswaController::class, 'importProcess'
    ])->name('import_mahasiswa_process');

    // EXPORT EXCEL MAHASISWA
    Route::get('/mahasiswa/export', [
        MahasiswaController::class, 'export'
    ])->name('export_mahasiswa');

    // HAPUS SEMUA DATA MAHASISWA
    Route::get('/mahasiswa/deleteall', [
        MahasiswaController::class, 'deleteAll'
    ])->name('delete_mahasiswa');

    // LIVE CHAT ADMIN
    Route::post('/message', function (Request $request) {
        event(
            new Message($request->username, $request->receiver, $request->message)
        );

        $d = [
            'from_name' => Crypt::encrypt($request->name),
            'to_name' => Crypt::encrypt($request->to_name),
            'from_username' => Crypt::encrypt($request->username),
            'sender' => Crypt::encrypt($request->username),
            'receiver' => Crypt::encrypt($request->receiver),
            'message' => Crypt::encrypt($request->message),
            'has_read' => 0,
            'sent_at' => \Carbon\Carbon::now()->format('H:i'),
            'chat_date' => \Carbon\Carbon::now()->isoFormat('D MMMM Y')
        ];

        DB::table('chat_history')->insert($d);
    });
    
    // CEK APAKAH ADMIN LEBIH DARI 1
    Route::get('/get_all_admin', function() {
        $data = DB::table('users')->select('name', 'username', 'image')->where('username', '!=', Auth::user()->username)->get();
        $count = DB::table('users')->count();
        if($count < 2) {
            return response()->json($count);
        }

        return response()->json($data);
    });

    // DAPATKAN SEMUA CHAT
    Route::get('/get_all_chat', function() {
        $data = DB::table('chat_history')->get();
        if(DB::table('chat_history')->count() < 1) {
            $count = ['count' => 0];
            return response()->json($count);
        }
    
        foreach ($data as $i) {
            $toArray[] = (array) $i;
        }

        foreach ($toArray as $h) {
            $dataChat[] = [
                'from_name' => Crypt::decrypt($h['from_name']),
                'to_name' => Crypt::decrypt($h['to_name']),
                'sender' => Crypt::decrypt($h['sender']),
                'receiver' => Crypt::decrypt($h['receiver']),
                'message' => Crypt::decrypt($h['message']),
                'has_read' => $h['has_read'],
                'sent_at' => $h['sent_at'],
                'chat_date' => $h['chat_date'],
                'login_name' => Auth::user()->name,
                'login_username' => Auth::user()->username
            ];
        }
        
        return response()->json($dataChat);
    });

    Route::post('/get_chat_history', function(Request $request) {
        $query = DB::table('chat_history')->get();

        foreach ($query as $q) {
            $toArray[] = (array) $q;
        }

        foreach ($toArray as $h) {
            $data_chat[] = [
                'sender' => Crypt::decrypt($h['sender']),
                'receiver' => Crypt::decrypt($h['receiver']),
                'message' => Crypt::decrypt($h['message']),
                'sent_at' => $h['sent_at'],
                'chat_date' => $h['chat_date'],
                'username_log' => Auth::user()->username
            ];
        }

        return response()->json($data_chat);
    });
});