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
use App\Http\Controllers\DeveloperSettingController;
use App\Http\Controllers\SendSMSController;
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
        Route::name('user.')

            ->prefix('users')->group(function () {
            Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
            Route::middleware('role')->get('/', [UserController::class, 'index'])->name('index');
            Route::middleware('role')->get('/{id}/fetch', [UserController::class, 'fetch'])->name('fetch');

            Route::middleware('role')->post('/', [UserController::class, 'create'])->name('create');
            Route::middleware('role')->put('/', [UserController::class, 'update'])->name('update');
            Route::middleware('role')->delete('/{id}', [UserController::class, 'delete'])->name('delete');
            Route::middleware('role')->get('/key-generate', [UserController::class, 'keyGenerate'])->name('key-generate');
        });

        // sender-info
        Route::name('sender-info.')->prefix('sender-info')->group(function () {
            Route::get('/', [SenderInfoController::class, 'index'])->name('index');
            Route::middleware('role')->get('/sender-id-generate', [SenderInfoController::class, 'senderIdGenerate'])->name('sender-id-generate');
            Route::middleware('role')->post('/', [SenderInfoController::class, 'create'])->name('create');
            Route::middleware('role')->put('/', [SenderInfoController::class, 'update'])->name('update');
            Route::delete('/{id}', [SenderInfoController::class, 'delete'])->name('delete');
            Route::middleware('role')->get('/{id}/fetch', [SenderInfoController::class, 'fetch'])->name('fetch');
        });

        // balance
        Route::middleware('role')->name('balance.')->prefix('balances')->group(function () {
            Route::get('/', [BalanceController::class, 'index'])->name('index');
            Route::middleware('role')->post('/', [BalanceController::class, 'store'])->name('store');
            Route::middleware('role')->put('/', [BalanceController::class, 'update'])->name('update');
            Route::middleware('role')->delete('/{id}', [BalanceController::class, 'delete'])->name('delete');
            Route::middleware('role')->get('/fetch/sender-info/{id}/by-user', [BalanceController::class, 'senderInfoByUser'])->name('sender-info.by-user');
            Route::middleware('role')->get('/fetch/{id}/', [BalanceController::class, 'fetch'])->name('fetch');

        });

        // fund
        Route::middleware('role')->name('fund.')->prefix('fund')->group(function () {
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

        Route::name('developer-settings.')
            ->prefix('developer-settings')->group(function () {
            Route::get('/', [DeveloperSettingController::class, 'index'])->name('index');
            Route::middleware('role')->post('/', [DeveloperSettingController::class, 'store'])->name('store');
            Route::middleware('role')->put('/', [DeveloperSettingController::class, 'update'])->name('update');
            Route::middleware('role')->get('/{id}/fetch', [DeveloperSettingController::class, 'fetch'])->name('fetch');
            Route::middleware('role')->delete('/{id}', [DeveloperSettingController::class, 'delete'])->name('delete');
        });

        Route::name('send-sms.')
            ->prefix('send-sms')->group(function () {
            Route::get('/', [SendSMSController::class, 'index'])->name('index');
            Route::post('/', [SendSMSController::class, 'sendSms'])->name('send');
            Route::get('/csv-info/{id}/fetch', [SendSMSController::class, 'csvInfoFetch'])->name('csv-info-fetch');
            Route::post('/bulk-sms', [SendSMSController::class, 'sendBulkSms'])->name('bulk-sms-send');
            Route::get('/log', [SendSMSController::class, 'smsLog'])->name('log');
            Route::get('/log/{id}/fetch', [SendSMSController::class, 'fetchLog'])->name('log.fetch');
        });

    });



