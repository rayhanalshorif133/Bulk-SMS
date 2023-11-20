<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Credit;

class CreditController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = Credit::orderBy('created_at', 'desc')->with('user','senderInfo','fund')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('credit.index');
    }
}
