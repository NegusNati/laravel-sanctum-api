<?php
use App\Http\Controllers\ProdController;
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

Route::resource('products',ProdController::class);
Route::get('/products/search/{name}', [ProdController::class, 'search']);

// Route::get('/products', [ProdController::class, 'index']);
// Route::post('/products',[ProdController::class,'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
