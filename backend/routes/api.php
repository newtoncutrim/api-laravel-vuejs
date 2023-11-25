<?php


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\PhotoApiController;
use App\Http\Controllers\Api\Auth\UserAuthController;

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
/* Route::get('/photos', [PhotoApiController::class, 'show']);

Route::get('/photos/{id}', [PhotoApiController::class, 'find'])->where('id', '[0-9]+');

Route::post('/up', [PhotoApiController::class, 'upload']);

Route::delete('/photos/{id}', [PhotoApiController::class, 'destroy'])->where('id', '[0-9]+');

Route::apiResource('/users', UserApiController::class);

Route::post('auth/login', [UserAuthController::class, 'login']); */

/* Route::get('users', function(){
    return User::all();
}); */
Route::post('auth/login', [UserAuthController::class, 'login']);
Route::apiResource('/users', UserApiController::class);


Route::middleware('auth:sanctum')->group(function (){
    Route::get('/photos', [PhotoApiController::class, 'show']);

    Route::get('/photos/{id}', [PhotoApiController::class, 'find'])->where('id', '[0-9]+');
    Route::post('/photo/{id}', [PhotoApiController::class, 'edit'])->where('id', '[0-9]+');

    Route::post('/up', [PhotoApiController::class, 'upload']);

    Route::delete('/photos/{id}', [PhotoApiController::class, 'destroy'])->where('id', '[0-9]+');
});

/* {
	"name": "newton",
	"email": "newton@gmail.com",
	"password": "S@xalto0982"
} */

/* "token": "1|SjY9MwKIPmgUQ8idTqAMyZ9gVz809VOfYSoxKH7p55ac8e40"
 */
