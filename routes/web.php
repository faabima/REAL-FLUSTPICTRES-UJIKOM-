<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;


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

  //Home Luar
  Route::get('/', function (){
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect('/dashboard');
        } else if (Auth::user()->role == 'user') {
            return redirect('/explore');
        }
    } else {
        return view('rumah');
    }
});

Route::middleware(['guest'])->group(function () {
    //Register
    Route::get('/register', function () {
        return view('register');
    });
    //proses register
    Route::post('/registered', [UserController::class, 'register']);
    //proses log in
    Route::post('/ceklogin', [UserController::class, 'ceklogin']);
    //view log in
    Route::get('/login', [UserController::class, 'viewlogin']);
    //resetemail
    Route::get('/resetemail', [UserController::class, 'emailreset']);
    //emailsend
    Route::post('/resetpassword', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //passwordreset
    Route::get('/resetpassword/{token}', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
    //PasswordUpdate
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    //apply pesan
    // Route::get('/pesanapply', [UserController::class, 'pesanapplyuser']);
    Route::get('/pesanapply', [UserController::class, 'pesanapplyuser']);
    //kirimpesan
    Route::post('/ajukanbanding', [UserController::class, 'pemulihanakun']);
});
//middleware user
Route::middleware(['user'])->group(function () {
    //data Explore
    Route::get('/getDataExplore',[UserController::class, 'getdata']);
    //likefoto
    Route::post('/likefoto' ,[UserController::class,'likesfoto']);
    // explore
    Route::get('/explore',[UserController::class, 'explore']);
    // explore-detail
    Route::get('/explore-detail/{id}',[UserController::class, 'explore_detail']);
    //datadetailexplore
    Route::get('/explore-detail/{id}/getdatadetail', [UserController::class, 'getdatadetail']);
    //Menampilakan Komentar
    Route::get('/explore-detail/getkomen/{id}', [UserController::class, 'ambildatakomentar']);
    //kirimkomentar
    Route::post('/explore-detail/kirimkomentar', [UserController::class, 'kirimkomentar']);
    //follow
    Route::post('/explore-detail/ikuti', [UserController::class, 'ikuti']);
    //upload
    Route::get('/upload',[UserController::class, 'upload']);
    //tambahalbum
    Route::post('/tambah_album',[UserController::class, 'tambahalbum']);
    //upload foto
    Route::post('/upload',[UserController::class, 'upload_foto']);
    //album
    Route::get('/album',[UserController::class, 'album']);
    //datapostinan
    Route::get('/getDataPostingan',[UserController::class, 'getdatapostingan']);
    //dataAlbum
    Route::get('/getDataAlbum',[UserController::class, 'getdataalbum']);
    //profil
    Route::get('/profile',[UserController::class, 'profil']);
    //updatedata
    Route::post('/updateprofile',[UserController::class, 'updatedataprofile']);
    //updatefotoprofile
    Route::post('/ubahprofil',[UserController::class, 'fotoprofil']);
    //about
    Route::get('/about',[UserController::class, 'about']);
    //changepassword
    Route::get('/password&username ',[UserController::class, 'edit_password_username']);
    //ubahpassword
    Route::post('/change-password', [UserController::class, 'update']);
    //profil public
    Route::get('/profil_public/{id}', [UserController::class, 'profil_public']);
    //fotopublic
    Route::get('/getDataPublic/{id}', [UserController::class, 'getdatapublic']);
    //log out
    Route::get('/logout ',[UserController::class, 'logout']);
    //delete
    Route::delete('/deletefoto/{id}', [UserController::class, 'deletefoto']);
    //hapusfotoprofil
    Route::delete('/hapusfotoprofil', [UserController::class, 'hapusprofil']);
    //cari
    Route::get('/search', [UserController::class, 'cari'])->name('search');
    //laporan
    Route::post('/laporkan', [UserController::class,'laporan']);
    //Mengambil postingan yang di edit
    Route::get('/editfotopostingan/{id}', [UserController::class, 'editpostinganew']);
    //proses simpann postigan
    Route::put('/update/{id}', [UserController::class, 'updatepostingan']);
});
//middleware Admin
Route::middleware(['admin'])->group(function () {
    //dashboard
    Route::get('/dashboard ',[AdminController::class, 'dashboard_admin']);
    //dasbor.user
    Route::get('/datauser ',[AdminController::class, 'datauseradmin']);
    //dasbor.laporan
    Route::get('/laporan', [AdminController::class, 'laporan']);
    //admin.deletepostingan
    Route::delete('/delete-photo/{id}', [AdminController::class, 'deletePhoto'])->name('delete_photo');
    //admin.tolakpostingan
    Route::delete('/hapuslaporan/{id}', [AdminController::class, 'hapusLaporan'])->name('hapuslaporan');
    Route::post('/banned', [AdminController::class, 'nonAktifkanUser'])->name('banned');
    //tambahadmin
    Route::post('/tambahadmin', [AdminController::class,'tambah_admin']);
    //dasbor.profile
    Route::get('/profiladmin ',[AdminController::class, 'profile_admin']);
    //fotoadmin
    Route::post('/ubahprofiladmin', [AdminController::class, 'fotoprofiladmin']);
    //dataadmin
    Route::post('/updateprofileadmin', [AdminController::class, 'updatedataprofileadmin']);
    //dasbor.updatepassword
    Route::get('/passwordadmin ',[AdminController::class, 'passwordupdate']);
    //updatepasswordadmin
    Route::post('/change-passwordadmin', [AdminController::class, 'updateadmin']);
    //log out
    Route::get('/logoutadmin ',[AdminController::class, 'logoutadmin']);
    //pesan masuk banned
    Route::get('/kotakmasuk', [AdminController::class, 'kotakmasuk'])->name('kotakmasuk');
    //dasbor.tambahadmin
    Route::get('/tambahadmin', function () {
        return view('admin.tambah-admin');
    });
    //hapuspesan
    // routes/web.php
    Route::post('/hapuspesan', [AdminController::class, 'hapuspesan'])->name('hapuspesan');

});

Route::middleware(['guest'])->group(function () {
//login
Route::get('/loginadmin', function () {
    return view('admin.signin');
});
Route::post('/cekloginadmin', [AdminController::class, 'ceklogin_admin']);
});

