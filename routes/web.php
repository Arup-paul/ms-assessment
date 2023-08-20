<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawalController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Deposit
    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::get('/deposit/create', [DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');

     // Withdrawal
    Route::get('/withdraw', [WithdrawalController::class, 'index'])->name('withdraw.index');
    Route::get('/withdraw/create', [WithdrawalController::class, 'create'])->name('withdraw.create');
    Route::post('/withdraw', [WithdrawalController::class, 'store'])->name('withdraw.store');


});

require __DIR__.'/auth.php';
