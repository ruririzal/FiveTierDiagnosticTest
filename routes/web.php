<?php

use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Resource_;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {    
    Route::get('/', function () {
        return redirect('/settings');
    });
    Route::get('/settings', 'HomeController@index')->name('settings');
    Route::post('/profile', 'HomeController@updateProfile')->name('update_profile');
    Route::post('/password', 'HomeController@updatePassword')->name('update_password');

    // siswa
    Route::get('/tes', 'TesController@index')->name('tes');
    Route::get('/mulai-tes', 'TesController@mulai')->name('mulai_tes');
    Route::post('/simpan-jawaban', 'TesController@simpanJawaban')->name('simpan_jawaban');
    Route::post('/selesai-tes', 'TesController@selesaiTes')->name('selesai_tes');
    Route::post('/buat-rekap-jawaban', 'TesController@simpanJawaban')->name('buat_rekap_jawaban');

    // admin
    Route::group(['middleware' => 'is_admin'], function () {    
        Route::post('/durasi-tes', 'HomeController@updateDurasiTes')->name('update_durasi_tes');
        Route::post('soal/media', 'SoalController@storeMedia')->name('store_media');
        Route::resource('soal', 'SoalController');
        Route::get('siswa/download', 'HasilTesSiswaController@download')->name('download_tes');
        Route::get('siswa/hitung-ulang-hasil-tes', 'HasilTesSiswaController@reCalculateAllRekapTes')->name('hitung_ulang_hasil_tes');
        Route::delete('siswa/delete/{siswa}', 'SiswaController@destroy')->name('delete_siswa');
        Route::resource('siswa', 'HasilTesSiswaController')->only(['index', 'show', 'destroy']);
    });
});



