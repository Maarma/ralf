<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GoogleMapController;
use App\Http\Controllers\Api\RecordsController;
use App\Models\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather');

Route::get('api', [RecordsController::class, 'index'])->name('index');

Route::get('/pages', [GoogleMapController::class, 'index'])->name('google-map.index');
Route::post('/pages', [GoogleMapController::class, 'store'])->name('google-map.index');


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/show-api', function() {
    return match(request('name')) {
        'Ralf' => Cache::remember('movies', now()->addHour(), fn() => 
        Http::get('https://hajus.ta19heinsoo.itmajakas.ee/api/movies')->json()),
        'Liis' => Cache::remember('tools', now()->addHour(), fn() => 
        Http::get('https://hajusrakendus.ta22alber.itmajakas.ee/tools')->json()),
        'Mari-Liis' => Cache::remember('makeup', now()->addHour(), fn() => 
        Http::get('https://ralf.ta22sink.itmajakas.ee/api/makeup')->json()),
        default => Cache::remember('records', now()->addHour(), fn() => 
        Http::get('https://hajusrakendus.ta22maarma.itmajakas.ee/api/records')->json())
    };
});

require __DIR__.'/auth.php';
