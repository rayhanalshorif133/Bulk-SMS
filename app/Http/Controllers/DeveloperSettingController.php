<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperSettingController extends Controller
{
    public function index(){

        $base_url = url("");
        return view('developer-setting.index',compact('base_url'));
    }
}
