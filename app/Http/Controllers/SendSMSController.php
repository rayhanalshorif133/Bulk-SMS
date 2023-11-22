<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SMSLog;
use App\Http\Controllers\Api\ApiSendSMSController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SendSMSController extends Controller
{
    public function index(){
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'admin');
        })->get();
        return view('send-sms.index',compact('users'));
    }

    public function sendSms(Request $request){
        $user = User::find($request->user_id);
        
        if($user){

            $addRequest = [
                'text' => $request->message,
                'mobile_number' => $request->phone,
                'api_key' => $user->api_key,
                'type' => 1,
            ];

            $request->request->add($addRequest);
            $apiSendSMSController = new ApiSendSMSController();
            $apiSendSMSController->sendSms($request);
            
            return redirect()->back();
        }else{
            flash()->addError('User not found');
            return redirect()->back();
        }
        
    }

    public function smsLog(){
        if(Auth::user()->roles[0]->name == 'user'){
            if (request()->ajax()) {
                $query = SMSLog::orderBy('created_at', 'desc')
                    ->where('user_id',Auth::user()->id)
                    ->with('user')
                    ->get();
                 return DataTables::of($query)
                 ->addIndexColumn()
                 ->rawColumns(['action'])
                 ->toJson();
            }
        }else{
            if (request()->ajax()) {
                $query = SMSLog::orderBy('created_at', 'desc')
                    ->with('user')
                    ->get();
                 return DataTables::of($query)
                 ->addIndexColumn()
                 ->rawColumns(['action'])
                 ->toJson();
            }
        } 
        return view('send-sms.log');
    }
}
