<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;

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
});

