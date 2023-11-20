<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Fund;

class FundController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = Fund::orderBy('created_at', 'desc')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('fund.index');
    }
}
