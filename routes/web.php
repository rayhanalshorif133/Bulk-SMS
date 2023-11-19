<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

/*
|
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('user.dashboard');
    }else{
        return redirect()->route('user.login');
        // return view('welcome');
    }
});

Auth::routes();


Route::name('user.')
    ->group(function () {
    
    Route::get('login', [AuthController::class, 'userLogin'])->name('login');
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('index');
    

});

