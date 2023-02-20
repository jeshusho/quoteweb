<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
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
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        //return Inertia::render('Dashboard');
        return redirect('quotes');
    })->name('dashboard');
    
    Route::get('quotes/searchcustomers/{term}', [QuoteController::class, 'searchCustomers'])->name('quotes.searchcustomers');
    Route::get('quotes/searchservices/{term}/{jsonids}', [QuoteController::class, 'searchServices'])->name('quotes.searchservices');
    Route::get('quotes/searchparts/{term}/{jsonids}', [QuoteController::class, 'searchParts'])->name('quotes.searchparts');
    Route::get('quotes/selectedservice/{id}', [QuoteController::class, 'selectedService'])->name('quotes.selectedservice');

    Route::get('search/ruc/{number}', [DocumentController::class, 'ruc'])->name('search.ruc');
});
Route::group(['middleware' => 'auth'],function(){
    Route::resource('quotes',  QuoteController::class);
    Route::resource('exchanges', ExchangeController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('parts', PartController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('users', UserController::class);
});
Route::get('quotes/pdf/{extid}', [QuoteController::class, 'getPDF'])->name('quotes.pdf');
//Route::get('exchanges_createtoday', [ExchangeController::class, 'createToday'])->name('exchanges.createtoday');
//Route::get('exchanges_updatetoday', [ExchangeController::class, 'updateToday'])->name('exchanges.updatetoday');