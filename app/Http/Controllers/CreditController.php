<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Fund;
use App\Models\Credit;
use App\Models\User;
use App\Models\Balance;
use App\Models\SenderInfo;
use Illuminate\Support\Facades\Validator;

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
        $funds = Fund::all();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'admin');
        })->get();

        return view('credit.index', compact('users','funds'));
    }

    
    public function store(Request $request){
        

        
        
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'sender_info_id' => ['required'],
            'balance' => ['required'],
            'amount' => ['required'],
            'fund_id' => ['required'],
            'transection_id' => ['required'],
            'expired_date' => ['required'],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }

        

        try {
            $credit = new Credit();
            $credit->user_id = $request->user_id;
            $credit->sender_info_id = $request->sender_info_id;
            $credit->fund_id = $request->fund_id;
            $credit->amount = $request->amount;
            $credit->transaction_id = $request->transection_id;
            $credit->balance = $request->balance;
            $credit->status = $request->status;
            $credit->note = $request->note;
            $credit->save();


            // balance
            $findBalance = Balance::select()->where('user_id',$request->user_id)->first();
            if($findBalance){
                $balance = $findBalance;
                $balance->user_id = $request->user_id;
                $balance->sender_info_id = $request->sender_info_id;
                $balance->balance = (int)$findBalance->balance + (int)$request->balance;
                $balance->expired_at = $request->expired_date;
                $balance->status = $request->status;
            }else{
                $balance = new Balance();
                $balance->user_id = $request->user_id;
                $balance->sender_info_id = $request->sender_info_id;
                $balance->balance = $request->balance;
                $balance->expired_at = $request->expired_date;
                $balance->status = $request->status;
            }
            $balance->save();




            flash()->addSuccess("Credit created successfully");
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
            'status' => ['required'],
            'transection_id' => ['required'],
        ]);
        

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }

        

        try {
            $credit = Credit::find($request->id);
            $credit->sender_info_id = $request->sender_info_id;
            $credit->fund_id = $request->fund_id;
            $credit->amount = $request->amount;
            $credit->transaction_id = $request->transection_id;
            $credit->balance = $request->balance;
            $credit->status = $request->status;
            $credit->note = $request->note;
            $credit->save();
            flash()->addSuccess("Credit updated successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();
        
    }


    public function fetch($id){
        $credit = Credit::select()->where('id',$id)
            ->with('user','senderInfo','fund')
            ->first();
        $credit->senderInfos = SenderInfo::select()->where('user_id',$credit->user_id)->get();  
        return $this->respondWithSuccess('Successfully fetch credit', $credit);
    }

    public function delete($id){
        try{
            $credit = Credit::find($id);
            $credit->delete();
            return $this->respondWithSuccess('credit deleted successfully');
        } catch (\Exception $e) {
            return $this->respondWithError('Something went wrong.!',$e->getMessage());
        }
    }
}
