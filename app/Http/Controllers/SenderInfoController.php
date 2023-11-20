<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SenderInfoController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = User::orderBy('created_at', 'desc')->with('roles')->get();
             return DataTables::of($query)
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('user.index');
    }
}
