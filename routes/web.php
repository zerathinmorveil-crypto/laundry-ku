<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SerpiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('customer', CustomerController::class);
    Route::get('/customers/cetak-pdf', [CustomerController::class, 'cetakPdf'])->name('customers.cetak-pdf');
    Route::resource('serpices', SerpiceController::class);
    Route::get('/members/cetak-pdf', [MemberController::class, 'cetakPdf'])->name('members.cetak-pdf');
    Route::resource('members', MemberController::class);
    Route::get('/members/cetak-pdf/{jenis}', [MemberController::class, 'cetakPdfByJenis'])->name('members.cetak-pdf-by-jenis');
    Route::get('/transactions/cetak-pdf', [TransactionController::class, 'cetakPdf'])->name('transactions.cetak-pdf');
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/struk', [TransactionController::class, 'cetakStruk'])->name('transactions.struk');
    Route::get('/transactions/{transaction}/struk-pdf', [TransactionController::class, 'cetakStrukPdf'])->name('transactions.struk-pdf');
});

require __DIR__.'/auth.php';
