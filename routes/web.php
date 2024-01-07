<?php

use App\Http\Controllers\Invoice\BuyerController;
use App\Http\Controllers\Invoice\InvoiceDataController;
use App\Http\Controllers\Invoice\InvoicePdfController;
use App\Http\Controllers\Invoice\PriceController;
use App\Http\Controllers\Invoice\SellerBuyerDataController;
use App\Http\Controllers\Invoice\SellerController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', [InvoiceDataController::class, 'index']);

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::middleware('auth', 'data.presence')->group(function () {
    // Route for displaying page where user can generate invoice 
    Route::get('/generuj-fakture', [InvoiceDataController::class, 'index'])->name('dashboard');
    // Route for displaying page where user have access to currently used data in invoices
    Route::get('/dane-do-faktury', [SellerBuyerDataController::class, 'index'])
        ->middleware('invalidate-browser-cache')
        ->name('invoiceData');
    // Route for post request with invoice data
    Route::post('/faktura', [InvoicePdfController::class, 'collectData'])->name('collectData');
});



Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Invoice Data




Route::middleware('auth')->group(function () {
    // Route to collect and save initial seller data.
    Route::get('/pierwsze-dane-do-faktury/sprzedawca', [SellerController::class, 'index'])->name('firstTimeInvoiceDataSeller');
    // Route to save seller data in database
    Route::post('/pierwsze-dane-do-faktury/sprzedawca/zapisz', [SellerController::class, 'store'])->name('seller.invoice.store');
    // Route for updating seller data
    Route::patch('/dane-do-faktury/sprzedawca', [SellerController::class, 'update'])->name('seller.invoice.update');

    // Next roautes in this group do the same thing as the routes above
    Route::get('/pierwsze-dane-do-faktury/kupujacy', [BuyerController::class, 'index'])->name('firstTimeInvoiceDataBuyer');
    Route::post('/pierwsze-dane-do-faktury/kupujacy/zapisz', [BuyerController::class, 'store'])->name('buyer.invoice.store');
    Route::patch('/dane-do-faktury/kupujacy', [BuyerController::class, 'update'])->name('buyer.invoice.update');;

    Route::get('/pierwsze-dane-do-faktury/cena-podatek', [PriceController::class, 'index'])->name('firstTimePriceTaxData');
    Route::post('/pierwsze-dane-do-faktury/cena-podatek/zapisz', [PriceController::class, 'store'])->name('tax.price.store');
    Route::patch('/dane-do-faktury/cena-podatek', [PriceController::class, 'update'])->name('tax.price.update');
});

require __DIR__ . '/auth.php';

// Handling invalid urls
Route::get('/{vue_capture?}', function () {
    return redirect()->route('dashboard');
})->where('vue_capture', '[\/\w\.-]*');
