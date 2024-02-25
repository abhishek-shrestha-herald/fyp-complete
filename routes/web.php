<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebsiteController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:farmer',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/');
    })->name('dashboard');
});

Route::controller(WebsiteController::class)
    ->group(function () {
        Route::get('/', 'homepage');
        Route::get('/shop', 'listing');
        Route::get('/search', 'searchProduct');
    });

Route::controller(ProductController::class)
    ->prefix('/products')
    ->group(function () {
        Route::get('/{product}', 'getSingleProduct');
    });

Route::middleware([
    'auth:farmer',
    config('jetstream.auth_session'),
    'verified',
])
    ->controller(WebsiteController::class)
    ->group(function () {
        Route::get('/wishlist', 'wishlist');
        Route::get('/cart', 'cart');
        Route::get('/order-history', 'orderHistory');

        Route::prefix('/payment')
            ->controller(PaymentController::class)
            ->group(function () {
                Route::prefix('/esewa')
                    ->group(function () {
                        Route::get('initiate', 'initiateEsewaPayment');
                        Route::get('validate', 'validateEsewaPayment');
                    });
                Route::prefix('/khalti')
                    ->group(function () {
                        Route::get('initiate', 'initiateKhaltiPayment');
                        Route::get('validate', 'validateKhaltiPayment');
                    });
                Route::prefix('/sajilo-pay')
                    ->group(function () {
                        Route::get('initiate', 'initiateSajiloPayPayment');
                        Route::get('validate', 'validateSajiloPayPayment');
                    });
            });
    });
