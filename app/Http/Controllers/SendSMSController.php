<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SMSLog;
use App\Models\Balance;
use App\Models\BulkSMSFile;
use App\Models\SenderInfo;
use App\Models\BulkSMSMsisdn;
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
            if($request->sms_type == 'single'){
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
                if($request->hasFile('phone_csv_file')){
                    $file_name = time().'_'.$request->phone_csv_file->getClientOriginalName();
                    $file = $request->file('phone_csv_file');
                    $bulkSMSFile = new BulkSMSFile();
                    $bulkSMSFile->user_id = $user->id;
                    $bulkSMSFile->file_name = $file_name;
                    $bulkSMSFile->file_size = $request->phone_csv_file->getSize();
                    $bulkSMSFile->file_type = $request->phone_csv_file->extension();
                    $bulkSMSFile->file_path = '/bulk_sms_files/'.$file_name;
                    $file->move(public_path('bulk_sms_files'),$file_name);
                    $bulkSMSFile->message = $request->message;
                    $bulkSMSFile->status = 0;
                    $bulkSMSFile->type = 1;
                    $bulkSMSFile->created_date_time = now();
                    $bulkSMSFile->save();
                    return redirect('/send-sms/?type=bulk&bulk_sms_file_id='.$bulkSMSFile->id);
                }
            }

        }else{
            flash()->addError('User not found');
            return redirect()->back();
        }

    }

    public function sendBulkSms(Request $request){
        if(!$request->phone_csv_file_id){
            flash()->addError('CSV file not found, please try again');
            return redirect()->back();
        }
        $bulkSMSFile = BulkSMSFile::find($request->phone_csv_file_id);
        $file = $bulkSMSFile->file_path;
        $file = public_path($file);
        $csv = array_map('str_getcsv', file($file));
        $strpos = strpos($csv[0][0], "\r");
        if($strpos !== false){
            $csv = explode("\r", $csv[0][0]);
        }else{
            foreach($csv as $key => $value){
                $csv[$key] = $value[0];
            }
        }
        $user = User::find($bulkSMSFile->user_id);
        $findSenderInfo = SenderInfo::select()->where('user_id',$user->id)->first();
        foreach($csv as $key => $value){
            $bulkSMSMsisdn = new BulkSMSMsisdn();
            $bulkSMSMsisdn->user_id = $user->id;
            $bulkSMSMsisdn->bulk_s_m_s_file_id = $bulkSMSFile->id;
            $bulkSMSMsisdn->api_key = $user->api_key;
            $bulkSMSMsisdn->sender_id = $findSenderInfo->sender_id;
            $bulkSMSMsisdn->mobile_number = $value;
            $bulkSMSMsisdn->message = $bulkSMSFile->message;
            $bulkSMSMsisdn->status = 0;
            $bulkSMSMsisdn->type = 1;
            $bulkSMSMsisdn->created_date_time = now();
            $bulkSMSMsisdn->save();

            // create log:start
            $smsLog = new SMSLog();
            $smsLog->user_id = $user->id;
            $smsLog->status = 0;
            $smsLog->api_key = $user->api_key;
            $smsLog->sender_id = $findSenderInfo->sender_id;
            $smsLog->message = $bulkSMSFile->message;
            $smsLog->mobile_number = $value;
            $smsLog->our_api = "https://msg.elitbuzz-bd.com/smsapi";
            $smsLog->type = 3; // for Bulk sms
            $smsLog->created_date_time = now();
            $smsLog->save();
            // create log:end
        }
        // $bulkSMSFile->status = 1;
        // $bulkSMSFile->save();
        flash()->addSuccess('Bulk sms send successfully');
        return redirect()->route('send-sms.index');
    }

    public function csvInfoFetch($id){

        $bulkSMSFile = BulkSMSFile::find($id);
        $file = $bulkSMSFile->file_path;
        $file = public_path($file);
        // get file extension
        // $file_ext = $bulkSMSFile->file_type;
        // return $this->respondWithSuccess('Bulk sms file fetch successfully',$file_ext);
        $csv = array_map('str_getcsv', file($file));
        $strpos = strpos($csv[0][0], "\r");
        if($strpos !== false){
            $csv = explode("\r", $csv[0][0]);
        }else{
            // array to 1 array
            foreach($csv as $key => $value){
                $csv[$key] = $value[0];
            }
        }

        $duplicate = array();

        // find duplicate number of $csv file

        $getBalance = Balance::select()->where('user_id',$bulkSMSFile->user_id)->first();


        $data = [
            'sms_balance' => $getBalance? $getBalance->balance : 0,
            'sms_uploaded_number' => count($csv),
            'sms_valid_number' => 0,
            'sms_invalid_number' => 0,
            'sms_cost' => count($csv),
            'numbers' => $csv,
        ];
        return $this->respondWithSuccess('Bulk sms file fetch successfully',$data);
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

    public function bulkSmsFile(){
        if (request()->ajax()) {
            if(Auth::user()->roles[0]->name == 'user'){
                $query = BulkSMSMsisdn::orderBy('created_at', 'desc')
                    ->where('user_id',Auth::user()->id)
                    ->with('user')
                    ->get();
            }else{
                $query = BulkSMSMsisdn::orderBy('created_at', 'desc')
                    ->with('user')
                    ->get();
            }
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();

        }
        if(Auth::user()->roles[0]->name == 'user'){
            $total_send_sms = BulkSMSMsisdn::where('user_id',Auth::user()->id)->count();
            $total_success_sms = BulkSMSMsisdn::where('user_id',Auth::user()->id)->where('status',1)->count();
            $total_failed_sms = BulkSMSMsisdn::where('user_id',Auth::user()->id)->where('status',0)->count();
        }else{
            $total_send_sms = BulkSMSMsisdn::count();
            $total_success_sms = BulkSMSMsisdn::where('status',1)->count();
            $total_failed_sms = BulkSMSMsisdn::where('status',0)->count();
        }
        return view('send-sms.bulk-sms-file',compact('total_send_sms','total_success_sms','total_failed_sms'));
    }

    public function fetchLog($id){
        $SMSLog = SMSLog::find($id);
        return $this->respondWithSuccess('Send sms log fetch successfully',$SMSLog);
    }

    public function fetchBulkSMSMsisdn($id){
        $bulkSMSMsisdn = BulkSMSMsisdn::find($id);
        return $this->respondWithSuccess('Bulk sms msisdn fetch successfully',$bulkSMSMsisdn);
    }
}
