<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SMSLog;
use App\Models\SenderInfo;

class ApiSendSMSController extends Controller
{
    public function sendSMS(Request $request)
    {

        if($request->type){
            $findUser = User::select()->where('api_key',$request->api_key)->first();
            if(!$findUser){
                return $this->respondWithSuccess('Api key not found', [
                    'api_key' => $request->api_key
                ]);
            }
        }else{
            $findUser = User::select()->where('api_key',$request->api_key)->first();
            $findSenderInfo = SenderInfo::select()->where('user_id',$findUser->id)->first();
            if(!$findSenderInfo){
                return $this->respondWithSuccess('Api key not found', [
                    'api_key' => $request->api_key
                ]);
            }
        }
        


        try {

            // send sms:start

                $post_body = array(
                    'api_key' => $request->type? $findUser->api_key : $findSenderInfo->api_key,
                    'type' => 'text',
                    'contacts' => $request->mobile_number,
                    'senderid' => $findSenderInfo->sender_id,
                    'msg' => $request->text,
                );

                $curl = curl_init();

                

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://msg.elitbuzz-bd.com/smsapi',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>  $post_body,
                ));

                $response = curl_exec($curl);

                curl_close($curl);


            // send sms:end

            $smsLog = new SMSLog();
            $smsLog->user_id = $findUser->id;
            $smsLog->api_key = $request->type? $findUser->api_key : $findSenderInfo->api_key;
            $smsLog->message = $request->text;
            $smsLog->mobile_number = $request->mobile_number;
            $smsLog->our_api = "https://google.com/our-api-url";
            $smsLog->our_api_response = 1;
            $smsLog->type = $request->type? $request->type : 2;
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
