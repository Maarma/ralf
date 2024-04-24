<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecordsController;

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
//auth:sanctum
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('/records', [RecordsController::class, 'index']);
Route::post('/records', [RecordsController::class, 'store']);
Route::get('/records/{id}', [RecordsController::class, 'show']);
Route::put('/records/{id}', [RecordsController::class, 'update']);
Route::delete('/records/{id}', [RecordsController::class, 'destroy']);

Route::get('tools', function(Request $request){

    if ($limit = request('limit')) {
        return Cache::remember('my-request'.$limit, now()->addHour(), fn () => Tools::paginate($limit));
    }
    return Tools::all();
});