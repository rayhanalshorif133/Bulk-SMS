<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SMSLog;
use App\Models\SenderInfo;
use App\Models\Balance;

class ApiSendSMSController extends Controller
{
    public function sendSMS(Request $request)
    {
        if($request->message != null){
            $request->text = $request->message;
        }

        $findUser = User::select()->where('api_key',$request->api_key)->first();
        if(!$findUser){
            return $this->respondWithSuccess('Api key not found', [
                'api_key' => $request->api_key
            ]);
        }
        $findSenderInfo = SenderInfo::select()->where('user_id',$findUser->id)->first();
        if(!$findSenderInfo){
            return $this->respondWithSuccess('Sender Api key not found', [
                'api_key' => $request->api_key
            ]);
        }



        try {

            $findBalance = Balance::select()->where('user_id',$findUser->id)->first();


            if(!$findBalance || (int)$findBalance->balance <= 0){
                if (!$request->expectsJson()) {
                    flash()->addError('Insufficient balance');
                    return redirect()->back();
                }else{
                    $customer_response = [
                        'code' => 201,
                        'msg'=> 'Insufficient balance',
                    ];
                    return response()->json($customer_response);
                }
            }

            // send sms:start
                $post_body = array(
                    'api_key' => $findSenderInfo->api_key,
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






            $smsLog = new SMSLog();
            $sms = $request->text;

            // get length of sms
            $sms_length = strlen($sms);
            $sms_count = ceil($sms_length/160);

            if(!is_numeric($response)){
                $findBalance->balance = (int)$findBalance->balance - (int)$sms_count;
                $findBalance->save();
                $customer_response = [
                    'code' => 200,
                    'msg'=> 'Successful sent SMS.',
                ];

                $smsLog->status = 1;
            }else{
                $customer_response = [
                    'code' => 201,
                    'msg'=> 'SMS Not Sent',
                ];
                $smsLog->status = 0;
            }


            $smsLog->user_id = $findUser->id;
            $smsLog->api_key = $request->api_key;
            $smsLog->sms_count = $sms_count;
            $smsLog->sender_id = $findSenderInfo->sender_id;
            $smsLog->message = $request->text;
            $smsLog->mobile_number = $request->mobile_number;
            $smsLog->our_api = "https://msg.elitbuzz-bd.com/smsapi";
            $smsLog->our_api_response = $response;
            $smsLog->type = $request->type? $request->type : 2;
            $smsLog->customer_response = json_encode($customer_response);
            $smsLog->created_date_time = now();
            $smsLog->save();

            if($request->type){
                return redirect()->back();
            }else{
                return response()->json($customer_response);
            }

          } catch (\Exception $e) {
            return $this->respondWithSuccess('Something went wrong',$e->getMessage());
          }
          return redirect()->back();


    }
}
