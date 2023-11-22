<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SMSLog;

class SendSMSController extends Controller
{
    // http://localhost:3000/api/sendsms?api_key=1c9dbe844194a856241a&mobile_number=+8801323174104&text=hello%20world
    public function sendSMS(Request $request)
    {
        $findUser = User::select()->where('api_key',$request->api_key)->first();
        if(!$findUser){
            return $this->respondWithSuccess('Api key not found', [
                'api_key' => $request->api_key
            ]);
        }

        try {

            // send sms:start



            // send sms:end

            $smsLog = new SMSLog();
            $smsLog->user_id = $findUser->id;
            $smsLog->api_key = $findUser->api_key;
            $smsLog->message = $request->text;
            $smsLog->mobile_number = $request->mobile_number;
            $smsLog->our_api = "https://google.com/our-api-url";
            $smsLog->our_api_response = 1;
            $smsLog->type = 2;
            $smsLog->status = 1;
            $smsLog->customer_response = "customer_response";
            $smsLog->created_date_time = now();
            $smsLog->save();
            return $this->respondWithSuccess('Successfully send a msg',$smsLog);
          } catch (\Exception $e) {
            return $this->respondWithSuccess('Something went wrong',$e->getMessage());
          }
          return redirect()->back();

        
    }
}
