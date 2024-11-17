<?php

use App\Model\Hardscape;
use App\Model\Softscape;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')
    ->name('api.')
    ->group(function () {

        Route::get('imbas', 'ScanController@qrcode')->name('imbas');

        Route::post('lembut/jenis', 'SoftscapeController@jenis')->name('lembut.jenis')->middleware('cors');
        Route::get('lembut/jenis', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('lembut/zon', 'SoftscapeController@zon')->name('lembut.zon')->middleware('cors');
        Route::get('lembut/zon', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('lembut/gambar/simpan', 'SoftscapeController@gambarsimpan')->name('lembut.gambar.simpan')->middleware('cors');
        Route::post('lembut/gambar/hapus', 'SoftscapeController@gambarhapus')->name('lembut.gambar.hapus')->middleware('cors');
        Route::post('lembut/gambar', 'SoftscapeController@gambar')->name('lembut.gambar')->middleware('cors');
        Route::get('lembut/gambar', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('lembut/{key?}', 'SoftscapeController@all')->name('lembut.all')->middleware('cors');
        Route::get('lembut/{key?}', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('lembut-save', 'SoftscapeController@save')->name('lembut.save')->middleware('cors');

        Route::post('kejur/jenis', 'HardscapeController@jenis')->name('kejur.jenis')->middleware('cors');
        Route::get('kejur/jenis', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('kejur/zon', 'HardscapeController@zon')->name('kejur.zon')->middleware('cors');
        Route::get('kejur/zon', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('kejur/gambar/simpan', 'HardscapeController@gambarsimpan')->name('kejur.gambar.simpan')->middleware('cors');
        Route::post('kejur/gambar/hapus', 'HardscapeController@gambarhapus')->name('kejur.gambar.hapus')->middleware('cors');
        Route::post('kejur/gambar', 'HardscapeController@gambar')->name('kejur.gambar')->middleware('cors');
        Route::get('kejur/gambar', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('kejur/{key?}', 'HardscapeController@all')->name('kejur.all')->middleware('cors');
        Route::get('kejur/{key?}', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('kejur-save', 'HardscapeController@save')->name('kejur.save')->middleware('cors');

        Route::post('verify', 'AuthController@verify')->name('verify')->middleware('cors');
        Route::get('verify', function () {return redirect()->route('welcome');})->middleware('cors');

        Route::post('login', 'AuthController@login')->name('login')->middleware('cors');
        Route::get('verify', function () {return redirect()->route('welcome');})->middleware('cors');
    });
