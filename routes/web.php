<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GoogleMapController;

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


Route::get('/pages', [GoogleMapController::class, 'index'])->name('google-map.index');
Route::post('/pages', [GoogleMapController::class, 'store'])->name('google-map.index');


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('show-api', function() {
    $requestUrl = match(request('name')) {
        'Ralf' => 'https://hajus.ta19heinsoo.itmajakas.ee/api/movies',
        'Liis' => 'https://hajusrakendus.ta22alber.itmajakas.ee/tools',
        default => 'https://hajusrakendus.ta22maarma.itmajakas.ee/api/records'
    };
});

require __DIR__.'/auth.php';
