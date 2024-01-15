<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SMSLog;
use App\Models\BulkSMSFile;
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

    public function csvInfoFetch($id){
        $bulkSMSFile = BulkSMSFile::find($id);
        $file = $bulkSMSFile->file_path;
        $file = public_path($file);
        $csv = array_map('str_getcsv', file($file));
        $csv = explode("\r", $csv[0][0]);
        $duplicate = array();

        // find duplicate number of $csv file
        foreach($csv as $key => $value){
            $duplicate[$value] = isset($duplicate[$value]) ? $duplicate[$value] + 1 : 1;
        }


        $data = [
            'sms_balance' => 0,
            'sms_uploaded_number' => count($csv),
            'sms_valid_number' => 0,
            'sms_invalid_number' => 0,
            'sms_duplicates_number' => count($duplicate),
            'sms_cost' => 0,
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

    public function fetchLog($id){
        $SMSLog = SMSLog::find($id);
        return $this->respondWithSuccess('Send sms log fetch successfully',$SMSLog);
    }
}
