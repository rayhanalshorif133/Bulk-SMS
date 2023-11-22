<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperSettingController extends Controller
{
    public function index(){
        return view('developer-setting.index');
    }
}
