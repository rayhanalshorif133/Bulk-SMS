<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiSendSMSController;

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
            flash()->addSuccess('Successfully sent message');
            return redirect()->back();
        }else{
            flash()->addError('User not found');
            return redirect()->back();
        }
        
    }
}
