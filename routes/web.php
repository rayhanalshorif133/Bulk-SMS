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
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        });

        // sender-info
        Route::name('sender-info.')->prefix('sender-info')->group(function () {
            Route::get('/', [SenderInfoController::class, 'index'])->name('index');
        });

        // balance
        Route::name('balance.')->prefix('balances')->group(function () {
            Route::get('/', [BalanceController::class, 'index'])->name('index');
        });
        
        // fund
        Route::name('fund.')->prefix('fund')->group(function () {
            Route::get('/', [FundController::class, 'index'])->name('index');
        });

        // credit
        Route::name('credit.')->prefix('credit')->group(function () {
            Route::get('/', [CreditController::class, 'index'])->name('index');
        });

    });
    


