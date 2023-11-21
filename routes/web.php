<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SenderInfoController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;
use Illuminate\Support\Facades\Artisan;

/*
|
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    return 'Clear';
});

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('user.dashboard');
    }else{
        return redirect()->route('user.login');
        // return view('welcome');
    }
});

Auth::routes();

Route::get('login', [AuthController::class, 'userLogin'])->name('user.login');


Route::middleware('auth')
    ->group(function(){

        // user
        Route::name('user.')->prefix('users')->group(function () {
            Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/fetch', [UserController::class, 'fetch'])->name('fetch');

            Route::post('/', [UserController::class, 'create'])->name('create');
            Route::put('/', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
            Route::get('/key-generate', [UserController::class, 'keyGenerate'])->name('key-generate');
        });
        
        // sender-info
        Route::name('sender-info.')->prefix('sender-info')->group(function () {
            Route::get('/', [SenderInfoController::class, 'index'])->name('index');
            Route::get('/sender-id-generate', [SenderInfoController::class, 'senderIdGenerate'])->name('sender-id-generate');
            Route::post('/', [SenderInfoController::class, 'create'])->name('create');
            Route::put('/', [SenderInfoController::class, 'update'])->name('update');
            Route::delete('/{id}', [SenderInfoController::class, 'delete'])->name('delete');
            Route::get('/{id}/fetch', [SenderInfoController::class, 'fetch'])->name('fetch');
        });

        // balance
        Route::name('balance.')->prefix('balances')->group(function () {
            Route::get('/', [BalanceController::class, 'index'])->name('index');
            Route::post('/', [BalanceController::class, 'store'])->name('store');
            Route::put('/', [BalanceController::class, 'update'])->name('update');
            Route::delete('/{id}', [BalanceController::class, 'delete'])->name('delete');

            Route::get('/fetch/sender-info/{id}/by-user', [BalanceController::class, 'senderInfoByUser'])->name('sender-info.by-user');
            Route::get('/fetch/{id}/', [BalanceController::class, 'fetch'])->name('fetch');

        });
        
        // fund
        Route::name('fund.')->prefix('fund')->group(function () {
            Route::get('/', [FundController::class, 'index'])->name('index');
            Route::post('/', [FundController::class, 'store'])->name('store');
            Route::put('/', [FundController::class, 'update'])->name('update');
            Route::get('/{id}/fetch', [FundController::class, 'fetch'])->name('fetch');
            Route::delete('/{id}', [FundController::class, 'delete'])->name('delete');
        });

        // credit
        Route::name('credit.')->prefix('credit')->group(function () {
            Route::get('/', [CreditController::class, 'index'])->name('index');
            Route::post('/', [CreditController::class, 'store'])->name('store');
            Route::put('/', [CreditController::class, 'update'])->name('update');
            Route::get('/{id}/fetch', [CreditController::class, 'fetch'])->name('fetch');
            Route::delete('/{id}', [CreditController::class, 'delete'])->name('delete');
        });

    });
    


