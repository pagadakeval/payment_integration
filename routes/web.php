<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\paypalController;
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
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(StripeController::class)->group(function(){
// Route::get('dashboard','showSubscription');
Route::post('single-charge','singleCharge')->name('single-charge');
});

Route::view('data','data');

Route::post('data', [paypalController::class, 'payment'])->name('payment');
Route::get('success', [paypalController::class, 'success'])->name('success');
Route::get('error', [paypalController::class, 'error'])->name('cancel');

// Route::get('paypal',function(){
//     return view('myOrder');
// });

// // route for processing payment
// Route::post('dashboard', [paypalController::class, 'createPayment'])->name('paypal');

// route for check status of the payment
// Route::get('status', [paypalController::class, 'getPaymentStatus'])->name('status');