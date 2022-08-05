<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdController;

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
//for CRUD applicaton without Sanctum Autentication 
// Route::resource('products',ProdController::class);




//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProdController::class, 'index']);
Route::get('/products/{id}', [ProdController::class, 'show']);
Route::get('/products/search/{name}', [ProdController::class, 'search']);



// Protected Routes 
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/products', [ProdController::class, 'store']);
    Route::put('/products/{id}', [ProdController::class, 'update']);
    Route::delete('/products/{id}', [ProdController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
