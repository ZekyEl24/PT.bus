<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HubungiController;
use App\Http\Controllers\Admin\InfoKontakController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\ProfilKlienController;
use App\Http\Controllers\Admin\ProfilPerusahaanController;
use App\Http\Controllers\Admin\UnitBisnisController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Models\Profil;
use App\Models\UnitBisnis;
use App\Models\Banner;
use App\Models\Hubungi;
use App\Models\Informasi;
use App\Models\InfoKontak;
use App\Models\ProfilKlien;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $profil = Profil::with('misi')->find(1);
    $unitBisnis = UnitBisnis::with('layanan')->where('status', 'aktif')->get();
    $banners = Banner::whereIn('kategori', ['utama', 'tentang kami'])->where('status', 'aktif')->get();
    $hubungi = Hubungi::first();
    $informasi = Informasi::where('status', 'aktif')->latest()->get();
    $kontak = InfoKontak::first();
    $klien = ProfilKlien::where('status', 'aktif')->latest()->get();

    return view('app', compact('profil', 'unitBisnis', 'banners', 'hubungi', 'informasi', 'kontak', 'klien'));
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('dasbor', DashboardController::class);
    Route::resource('informasiterkini', InformasiController::class);
    Route::resource('ub', UnitBisnisController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('profilklien', ProfilKlienController::class);
    Route::resource('user', UsersController::class);
    Route::get('user-search', [UsersController::class, 'search'])
        ->name('user.search');

    Route::resource('profilperusahaan', ProfilPerusahaanController::class)->only([
    'index', 'update'
]);
    Route::resource('infokontak', InfoKontakController::class);
    Route::resource('hubungi', HubungiController::class);


});