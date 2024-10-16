<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TahunController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\DevisiController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\KriteriacController;
use App\Http\Controllers\Admin\KriteriasController;
use App\Http\Controllers\Admin\KriteriapController;
use App\Http\Controllers\Admin\KriterianbController;
use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\HitungController;
use App\Http\Controllers\Pimpinan\AlternatifnbpController;
use App\Http\Controllers\Pimpinan\HitungpController;
use App\Http\Controllers\Pimpinan\AdminpController;
use App\Http\Controllers\Pimpinan\PeriodepController;
use App\Http\Controllers\Pimpinan\DevisisController;
use App\Http\Controllers\Admin\NilaiController;

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
    return view('welcome');
});
 
Route::get('/rank', [App\Http\Controllers\Depan\DepanController::class,'index'])->name('rank');
Route::get('/rank/{periodes}/show/{hitung}', [App\Http\Controllers\Depan\DepanController::class,'show'])->name('showrank'); 
Route::get('/rank/{periodes}/rekapanedp', [App\Http\Controllers\Depan\DepanController::class,'rekapandep'])->name('rekapanz'); 

Auth::routes();

Route::get('admin',[App\Http\Controllers\Midel\RasaAdminController::class, 'index'])->name('rasaadmin')->middleware('rasaadmin');
Route::get('pimpinan', [App\Http\Controllers\Midel\RasaPimpinanController::class, 'index'])->name('rasapimpinan')->middleware('rasapimpinan');
Route::get('tamu', [App\Http\Controllers\Midel\RasaTamuController::class, 'index'])->name('rasatamu')->middleware('rasatamu');

Route::group(['prefix' => 'admin','namespace','middleware' => 'auth', 'rasaadmin'],function(){ 
	Route::resource('/admin', AdminController::class); 
	Route::resource('periode', PeriodeController::class);
	Route::resource('periode/{periodes}/devisi', DevisiController::class);
	Route::resource('periode/{periodes}/devisi/{devisis}/kriteria', KriteriaController::class);
	Route::resource('periode/{periodes}/devisi/{devisis}/kriterianb', KriterianbController::class);
	Route::resource('periode/{periodes}/alternatif', AlternatifController::class); 
	Route::get('periode/{periodes}/perhitungan', [HitungController::class, 'index'])->name('perhitungan.index');
	Route::get('periode/{periodes}/perhitungan/{perhitungan}/show', [HitungController::class, 'show'])->name('perhitungan.show');
	Route::get('periode/{periodes}/perhitungan/rekapan', [HitungController::class, 'rekapansx'])->name('rekapankk');
	Route::resource('periodes/{periodes}/alternatifnb', AlternatifnbpController::class);
	Route::resource('periode/{periodes}/devisi/{devisis}/kriteria/{kriteria}/nilai', NilaiController::class);
});

Route::group(['prefix' => 'pimpinan','namespace','middleware' => 'auth', 'rasapimpinan'],function(){
	Route::resource('periodes/{periodes}/alternatifnbp', AlternatifnbpController::class);
	Route::resource('/admins', AdminpController::class); 
	Route::resource('periodes', PeriodepController::class);
	Route::resource('periodes/{periodes}/devisis', DevisisController::class);	 
	Route::get('periodes/{periodes}/perhitungans', [HitungpController::class, 'index'])->name('perhitungans.index');
	Route::get('periodes/{periodes}/perhitungans/{perhitungan}/show', [HitungpController::class, 'show'])->name('perhitungans.show');
	Route::get('periodes/{periodes}/perhitungans/rekapans', [HitungpController::class, 'rekapan'])->name('rekapans');
});