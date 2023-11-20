<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SenderInfoController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\UserController;
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

Route::name('user.')
    ->middleware('auth')
    ->group(function () {
    
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('index');


    
    
});



Route::get('balance', [BalanceController::class, 'index'])->name('balance.index');
Route::get('sender-info', [SenderInfoController::class, 'index'])->name('sender-info.index');
Route::get('fund', [SenderInfoController::class, 'index'])->name('fund.index');
Route::get('credit', [SenderInfoController::class, 'index'])->name('credit.index');

