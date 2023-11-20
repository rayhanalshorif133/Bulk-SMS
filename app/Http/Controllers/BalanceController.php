<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = Balance::orderBy('created_at', 'desc')->with('user','senderInfo')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('balance.index');
    }
}
