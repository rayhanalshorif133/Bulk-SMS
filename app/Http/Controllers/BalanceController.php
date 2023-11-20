<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Balance;
use App\Models\User;
use App\Models\SenderInfo;

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

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'admin');
        })->get();


        return view('balance.index', compact('users'));
    }

    public function create(){
        return view('balance.create');
    }

    public function senderInfoByUser($id){
        $senderInfo = SenderInfo::select()->where('user_id',$id)->get();
        return $this->respondWithSuccess('Successfully fetch sender info', $senderInfo);
    }
}
