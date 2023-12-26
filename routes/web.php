<?php

use Illuminate\Support\Facades\Auth; //class untuk Route
use Illuminate\Support\Facades\Route; //class untuk auth

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
route::get("/","LoginController@login" )->name("index");
route::post("/","LoginController@authenticate")->name("authenticate");
// Route::post('/login', 'App\Http\Controllers\LoginController@authenticate')->name("authenticate");
route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'guest'], function () {
    // Rute-rute yang hanya dapat diakses oleh tamu
    // lupa password
    route::get('/lupa', 'LoginController@lupa')->name('lupa');
    // kirim email 
    route::post("/kirim_email","LoginController@email")->name("kiriemail");

    // ke halaman reset password 
    route::post("/update-pass","LoginController@resetpass")->name("password.update");
    // route::get("/dashboard","LoginController@login" )->name("indexreset");
    // halaman login 
    route::get("/dashboard","LoginController@login" )->name("indexreset");
    
});


// 
Route::get('/starter', function () {
    return view('starter');
});
Auth::routes();

Route::middleware("auth")->group(function(){
    Route::get("/profile","IndexProfileController@index")->name("indexProfile");
    Route::get("/edit-profile","ProfileController@index")->name("Profile");
    // Route::get("/edit-profile/{profile}/edit","ProfileController@edit")->name("editProfile");
    Route::post("/edit-profile/{profile}/update", "ProfileController@update")->name("updateProfile");
    Route::get("/edit-profile/password", "ProfileController@editPassword")->name("editPassword");
    Route::post("/edit-profile/edit-password", "ProfileController@updatePassword")->name("updatePassword");
    Route::get("/edit-profile/password", "ProfileController@editPassword")->name("editPassword");
    Route::post("/edit-profile/edit-password", "ProfileController@updatePassword")->name("updatePassword");
});

Route::prefix("admin")->middleware("auth", "role:1")->group(function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    // divisi
    Route::get("/divisi","DivisiController@index")->name("daftarDivisi");
    Route::get("/divisi/create","DivisiController@create")->name("createDivisi");
    Route::post("/divisi/store","DivisiController@store")->name("storeDivisi");
    Route::get("/divisi/{divisi}/edit","DivisiController@edit")->name("editDivisi");
    Route::post("/divisi/{divisi}/update", "DivisiController@update")->name("updateDivisi");
    Route::get("/divisi/{divisi}/delete", "DivisiController@destroy")->name("deleteDivisi");

    // kategori
    Route::get("/kategori","KategoriController@index")->name("daftarKategori");
    Route::get("/kategori/create","KategoriController@create")->name("createKategori");
    Route::post("/kategori/store","KategoriController@store")->name("storeKategori");
    Route::get("/kategori/{kategori}/edit","KategoriController@edit")->name("editKategori");
    Route::post("/kategori/{kategori}/update", "KategoriController@update")->name("updateKategori");
    Route::get("/kategori/{kategori}/delete", "KategoriController@destroy")->name("deleteKategori");

    // role
    Route::get("/role","RoleController@index")->name("daftarRole");
    Route::get("/role/create","RoleController@create")->name("createRole");
    Route::post("/role/store","RoleController@store")->name("storeRole");
    Route::get("/role/{role}/edit","RoleController@edit")->name("editRole");
    Route::post("/role/{role}/update", "RoleController@update")->name("updateRole");
    Route::get("/role/{role}/delete", "RoleController@destroy")->name("deleteRole");

    //User
    Route::get("/user","UserController@index")->name("daftarUser");
    Route::get("/user/create","UserController@create")->name("createUser");
    Route::post("/user/store","UserController@store")->name("storeUser");
    Route::get("/user/{user}/edit","UserController@edit")->name("editUser");
    Route::post("/user/{user}/update", "UserController@update")->name("updateUser");
    Route::get("/user/{user}/delete", "UserController@destroy")->name("deleteUser");
    Route::get("/user/cetak","UserController@cetak")->name("cetakUser");
    

    //Profile
    // Route::get("/profile","IndexProfileController@index")->name("indexProfile");
    // Route::get("/edit-profile","ProfileController@index")->name("Profile");
    // Route::get("/edit-profile/{profile}/edit","ProfileController@edit")->name("editProfile");
    // Route::post("/edit-profile/{profile}/update", "ProfileController@update")->name("updateProfile");
    // Route::get("/edit-profile/password", "ProfileController@editPassword")->name("editPassword");
    // Route::post("/edit-profile/edit-password", "ProfileController@updatePassword")->name("updatePassword");
    // Route::get("/edit-profile/password", "ProfileController@editPassword")->name("editPassword");
    // Route::post("/edit-profile/edit-password", "ProfileController@updatePassword")->name("updatePassword");
}); 


Route::prefix('direktur')->middleware("auth", "role:2")->group(function () {
    Route::redirect('', '/direktur/dashboard');    

    Route::get('/dashboard', 'DirekturController@dashboard')->name("dashboardDirektur");
    Route::get('/mutasi', 'DirekturController@mutasi')->name('mutasiDirektur');
    Route::get('/anggaran', 'DirekturController@anggaran')->name("anggaranDirektur");
    Route::get('/karyawan', 'DirekturController@karyawan')->name("karyawanDirektur");

    Route::get('/mutasi/{id}/data', 'DirekturController@mutasiDivisi')->name('mutasiDivisi');

    //cetak
    Route::get("/mutasi/karyawan/cetak","DirekturController@mutasiKaryawanCetak")->name("cetakMutasiKaryawanDirektur");
});

Route::prefix('manajer')->middleware("auth", "role:3")->group(function () {
    Route::get("/","ManajerController@index")->name("dashboardManajer");

    // CRUD Anggaran
    Route::get("/anggaran","AnggaranController@index")->name("anggaran");
    Route::get("/anggaran/create","AnggaranController@create")->name("createAnggaran");
    Route::post("/anggaran/store","AnggaranController@store")->name("storeAnggaran");
    Route::get("/anggaran/{anggaran}/edit","AnggaranController@edit")->name("editAnggaran");
    Route::post("/anggaran/{anggaran}/update", "AnggaranController@update")->name("updateAnggaran");
    Route::post("/anggaran/{anggaran}/delete", "AnggaranController@destroy")->name("deleteAnggaran");
    
    // CRUD Karyawan
    Route::get("/karyawan","KaryawanController@index")->name("karyawan");
    Route::get("/karyawan/create","KaryawanController@create")->name("createKaryawan");
    Route::post("/karyawan/store","KaryawanController@store")->name("storeKaryawan");
    Route::post("/karyawan/{user}/edit","KaryawanController@edit")->name("editKaryawan");
    Route::post("/karyawan/{user}/update","KaryawanController@update")->name("updateKaryawan");
    Route::post("/karyawan/{user}/delete","KaryawanController@destroy")->name("deleteKaryawan");

    //CRUD Mutasi
    Route::get("/mutasi","MutasiController@index")->name("daftarMutasi");
    Route::post("/mutasi/tambah","MutasiController@store")->name("storeSaldo");
    Route::post("/mutasi/{pemasukan}/updatePemasukan","MutasiController@updatePemasukan")->name("mutasiPemasukan");
    Route::post("/mutasi/{pengeluaran}/updatePengeluaran","MutasiController@updatePengeluaran")->name("mutasiPengeluaran");
    Route::post("/mutasi/{pengeluaran}/deletePengeluaran","MutasiController@destroyPengeluaran")->name("deleteMutasiPengeluaran");
    Route::post("/mutasi/{pemasukan}/deletePemasukan","MutasiController@destroyPemasukan")->name("deleteMutasiPemasukan");
    Route::get('/view-bukti/{id}', 'MutasiController@viewBukti')->name('viewBukti');
});

Route::prefix('karyawan')->middleware("auth", "role:4")->group(function () {
    Route::get("/","DashboardKaryawanController@index")->name("dashboardKaryawan");

    //pemasukan
    Route::get('/pemasukan', 'PemasukanController@index')->name('daftarPemasukan');
    Route::get('/pemasukan/create', 'PemasukanController@create')->name('createPemasukan');
    Route::post('/pemasukan/store', 'PemasukanController@store')->name('storePemasukan');
    Route::get('/pemasukan/{pemasukan}/edit', 'PemasukanController@edit')->name('editPemasukan');
    Route::post('/pemasukan/{pemasukan}/edit', 'PemasukanController@update')->name('updatePemasukan');
    Route::get('/pemasukan/{pemasukan}/delete', 'PemasukanController@destroy')->name('deletePemasukan');
    Route::get("/pemasukan/cetak","PemasukanController@cetak")->name("cetakPemasukan");
    Route::get('/view-pemasukan/{id}', 'PemasukanController@viewPemasukan')->name('viewPemasukan');
    
    //pengeluaran
    Route::get('/pengeluaran', 'PengeluaranController@index')->name('daftarPengeluaran');
    Route::get('/pengeluaran/create', 'PengeluaranController@create')->name('createPengeluaran');
    Route::post('/pengeluaran/store', 'PengeluaranController@store')->name('storePengeluaran');
    Route::get('/pengeluaran/{pengeluaran}/edit', 'PengeluaranController@edit')->name('editPengeluaran');
    Route::post('/pengeluaran/{pengeluaran}/edit', 'PengeluaranController@update')->name('updatePengeluaran');
    Route::get('/pengeluaran/{pengeluaran}/delete', 'PengeluaranController@destroy')->name('deletePengeluaran');
    Route::get("/pengeluaran/cetak","PengeluaranController@cetak")->name("cetakPengeluaran");
    Route::get('/view-pengeluaran/{id}', 'PengeleuaranController@viewPemasukan')->name('viewPengeluaran');
});

// Route::get('dashboards', 'DashboardController@index')->middleware('admin');
