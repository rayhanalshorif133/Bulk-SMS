<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SenderInfo;

class SenderInfoController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = SenderInfo::orderBy('created_at', 'desc')
                ->with('user')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('sender-info.index');
    }
}
