<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// customers
Route::resource('customers',CustomerController::class)->middleware(['auth', 'verified']);


Route::middleware(['auth', 'verified'])->group(function() {
    
    Route::get('transactions/banknamesum',[TransactionController::class,'banknamesum']);
    Route::get('transactions/mosttransfers',[TransactionController::class,'mosttransfers']);
    Route::get('transactions/mostamount',[TransactionController::class,'mostamount']);

});


require __DIR__.'/auth.php';
