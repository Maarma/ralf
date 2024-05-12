<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GoogleMapController;
use App\Http\Controllers\RadarController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\Api\RecordsController;
use App\Models\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Http\Middleware\CacheMiddleware;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CommentController;

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

//Weather api page
Route::middleware([CacheMiddleware::class])->group(function () {
    Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather');
});

//Products pages
Route::get('/records', [RecordsController::class, 'records'])->name('records');
Route::get('/movies', [RecordsController::class, 'movies'])->name('movies');
Route::get('/makeup', [RecordsController::class, 'makeup'])->name('makeup');

//Shopping cart
//Route::get('addToCart/{product_id}', [RecordsController::class, 'cart'])->name('addToCart');
Route::post('addToCart/{product_id}/{quantity}', [RecordsController::class, 'addToCart'])->name('addToCart');
Route::get('cart', [RecordsController::class, 'showCart'])->name('cart');
Route::patch('/updateCartItem/{index}', [RecordsController::class, 'updateCartItem'])->name('updateCartItem');
Route::post('/removeFromCart/{index}', [RecordsController::class, 'removeFromCart'])->name('removeFromCart');


//Google map
Route::get('/pages', [GoogleMapController::class, 'index'])->name('google-map.index');
Route::post('/pages', [GoogleMapController::class, 'store'])->name('google-map.index');

//Radar map
Route::get('/radar', [RadarController::class, 'index'])->name('radar.index');
Route::post('/radar', [RadarController::class, 'create'])->name('radar.create');

//Map markers
Route::resource('/markers', MarkerController::class)
    ->only(['index','create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

//Blog posts
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

//Api resources
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
// Payment routes
Route::middleware(['auth', 'verified'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::post('/sessions', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
});
// Comment routes
Route::post('/chirps/{chirp}/comments', [ChirpController::class, 'storeComment'])->name('chirps.comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
//coumpons
Route::get('/coupons', [RecordsController::class, 'coupons']);
Route::post('/apply-coupon', [RecordsController::class, 'applyCoupon']);

require __DIR__.'/auth.php';
