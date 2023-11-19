<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function userLogin()
    {
        return view('auth.login');
    }
}
