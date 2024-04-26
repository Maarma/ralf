<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecordsController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

Route::get('/movies', function(Request $request){
    return Cache::remember('ralf-movies', now()->addHour(), fn() => 
    Http::get('https://hajus.ta19heinsoo.itmajakas.ee/api/movies', [
        'limit' => 1
    ])->json());
});
/*if ($limit = request('limit')) {
    return Cache::remember('my-request'.$limit, now()->addHour(), fn () => Tools::paginate($limit));
}*/
Route::get('/makeup', function(Request $request){
    return Cache::remember('makeup', now()->addHour(), fn() => 
    Http::get('https://ralf.ta22sink.itmajakas.ee/api/makeup')->json());
});
