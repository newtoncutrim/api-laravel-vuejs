<?php


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PhotoApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/photos', [PhotoApiController::class, 'show']);
Route::get('/photos/{id}', [PhotoApiController::class, 'find']);
Route::post('/up', [PhotoApiController::class, 'upload']);
Route::delete('/photos/{id}', [PhotoApiController::class, 'destroy']);

Route::get('users', function(){
    return User::all();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
