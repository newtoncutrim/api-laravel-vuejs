<?php

use App\Http\Controllers\TesteUpload;
use Illuminate\Support\Facades\Route;

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
Route::get('/exibir', [TesteUpload::class, 'testeUpload'])->name('teste.exibir');
//Route::post('/upload/file', [TesteUpload::class, 'store'])->name('upload');
Route::get('/up', [TesteUpload::class, 'up'])->name('teste.up');
Route::post('/teste', [TesteUpload::class, 'testeUpload_action'])->name('teste.upload');
Route::get('/', function () {
    return view('welcome');
});
