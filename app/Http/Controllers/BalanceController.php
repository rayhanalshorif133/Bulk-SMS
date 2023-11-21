<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Balance;
use App\Models\User;
use App\Models\SenderInfo;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request){
        
        
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'sender_info_id' => ['required'],
            'balance' => ['required'],
            'amount' => ['required'],
            'expired_date' => ['required'],
            'status' => ['required'],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }

        

        try {
            $balance = new Balance();
            $balance->user_id = $request->user_id;
            $balance->sender_info_id = $request->sender_info_id;
            $balance->balance = $request->balance;
            $balance->amount = $request->amount;
            $balance->expired_at = $request->expired_date;
            $balance->status = $request->status;
            $balance->save();
            flash()->addSuccess("Balance created successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();
        
    }


    public function update(Request $request){
        
        $validator = Validator::make($request->all(), [
            'sender_info_id' => ['required'],
            'balance' => ['required'],
            'amount' => ['required'],
            'expired_date' => ['required'],
            'modifyStatus' => ['required'],
        ]);
        

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }

        

        try {
            $balance = Balance::find( $request->id);
            $balance->sender_info_id = $request->sender_info_id;
            $balance->balance = $request->balance;
            $balance->amount = $request->amount;
            $balance->expired_at = $request->expired_date;
            $balance->status = $request->modifyStatus;
            $balance->save();
            flash()->addSuccess("Balance updated successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();
        
    }


    public function senderInfoByUser($id){
        $senderInfo = SenderInfo::select()->where('user_id',$id)->get();
        return $this->respondWithSuccess('Successfully fetch sender info', $senderInfo);
    }
    
    public function fetch($id){
        $balance = Balance::select()->where('id',$id)
            ->with('user')
            ->first();
        $senderInfo = SenderInfo::select()
            ->where('user_id',$balance->user_id)
            ->get();
        $data = [
            'balance' => $balance,
            'senderInfo' => $senderInfo
        ];
        return $this->respondWithSuccess('Successfully fetch balance with sender info', $data);
    }


    public function delete($id){
        try{
            $balance = Balance::find($id);
            $balance->delete();
            return $this->respondWithSuccess('Balance deleted successfully');
        } catch (\Exception $e) {
            return $this->respondWithError('Something went wrong.!',$e->getMessage());
        }
    }


}
