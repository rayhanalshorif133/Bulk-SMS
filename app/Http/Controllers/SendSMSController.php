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
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                    $bulkSMSFile->sms_count = $request->sms_count;
                    $bulkSMSFile->file_size = $request->phone_csv_file->getSize();
                    $bulkSMSFile->file_type = $request->phone_csv_file->extension();
                    $bulkSMSFile->file_path = '/bulk_sms_files/'.$file_name;
                    $file->move(public_path('bulk_sms_files'),$file_name);
                    $bulkSMSFile->message = $request->message;
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
        $file_ext = $bulkSMSFile->file_type;
        if($file_ext == 'xlsx'){
            $GET_CSV = [];
            // Exporter
            $spreadsheet = IOFactory::load($file);

            // Get the active sheet
            $sheet = $spreadsheet->getActiveSheet();

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            // read a file
            for ($row = 1; $row <= $highestRow; $row++) {
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cellValue = $sheet->getCell($col . $row)->getValue();
                    $GET_CSV[] = (string)$cellValue;
                }
            }
        }else{
            $csv = array_map('str_getcsv', file($file));
            $strpos = strpos($csv[0][0], "\r");
            $GET_CSV = [];
            if($strpos !== false){
                $csv = explode("\r", $csv[0][0]);
            }else{
                // array to 1 array
                foreach($csv as $key => $value){
                    if($key != 0){
                        $csv[$key] = $value[0];
                        $GET_CSV[] = $csv[$key];
                    }
                }
            }
        }
        $user = User::find($bulkSMSFile->user_id);
        $findSenderInfo = SenderInfo::select()->where('user_id',$user->id)->first();


        // check balance:start
        $getBalance = Balance::select()->where('user_id',$bulkSMSFile->user_id)->first();


        $getBalance->balance = (int)$getBalance->balance - (int)$bulkSMSFile->sms_count;
        $getBalance->save();


        $par_sms_count = (int)$bulkSMSFile->valid_number / (int)$bulkSMSFile->sms_count;


        foreach($GET_CSV as $key => $value){
            if($this->isValidBangladeshPhoneNumber($value)){
                $bulkSMSMsisdn = new BulkSMSMsisdn();
                $bulkSMSMsisdn->user_id = $user->id;
                $bulkSMSMsisdn->bulk_s_m_s_file_id = $bulkSMSFile->id;
                $bulkSMSMsisdn->api_key = $findSenderInfo->api_key;
                $bulkSMSMsisdn->sender_id = $findSenderInfo->sender_id;
                $bulkSMSMsisdn->mobile_number = $value;
                $bulkSMSMsisdn->sms_count = $par_sms_count;
                $bulkSMSMsisdn->message = $bulkSMSFile->message;
                $bulkSMSMsisdn->status = 0;
                $bulkSMSMsisdn->type = 1;
                $bulkSMSMsisdn->created_date_time = now();
                $bulkSMSMsisdn->save();

                // create log:end
            }
        }
        // $bulkSMSFile->status = 1;
        // $bulkSMSFile->save();
        flash()->addSuccess('Bulk sms send successfully');
        return redirect()->route('send-sms.index');
    }

    public function csvInfoFetch($id){

        $bulkSMSFile = BulkSMSFile::find($id);

        if(!$bulkSMSFile){
            return $this->respondWithError('Bulk sms file not found');
        }

        $file = $bulkSMSFile->file_path;
        $file = public_path($file);
        $file_ext = $bulkSMSFile->file_type;

        if($file_ext == 'xlsx'){
            $GET_CSV = [];
            // Exporter
            $spreadsheet = IOFactory::load($file);

            // Get the active sheet
            $sheet = $spreadsheet->getActiveSheet();

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            // read a file
            for ($row = 1; $row <= $highestRow; $row++) {
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cellValue = $sheet->getCell($col . $row)->getValue();
                    $GET_CSV[] = (string)$cellValue;
                }
            }
        }else{
            $csv = array_map('str_getcsv', file($file));
            $strpos = strpos($csv[0][0], "\r");
            $GET_CSV = [];
            if($strpos !== false){
                $csv = explode("\r", $csv[0][0]);
            }else{
                foreach($csv as $key => $value){
                    if($key != 0){
                        $csv[$key] = $value[0];
                        $GET_CSV[] = $csv[$key];
                    }
                }
            }
        }





        // check balance:start
        $getBalance = Balance::select()->where('user_id',$bulkSMSFile->user_id)->first();

        $valid_number = [];
        $invalid_number = [];
        foreach($GET_CSV as $key => $value){
            if($this->isValidBangladeshPhoneNumber($value)){
                $valid_number[] = $value;
            }else{
                $invalid_number[] = $value;
            }
        }

        $sms_cost = count($valid_number) * $bulkSMSFile->sms_count;
        $is_confirmed = false;

        if($getBalance){
            $is_confirmed = $getBalance->balance >= $sms_cost ? true : false;
        }


        $bulkSMSFile->valid_number = count($valid_number);
        $bulkSMSFile->invalid_number = count($invalid_number);
        $bulkSMSFile->sms_count = $sms_cost;
        $bulkSMSFile->save();

        // check balance:ending


        $data = [
            'sms_balance' => $getBalance? $getBalance->balance : 0,
            'sms_uploaded_number' => count($GET_CSV),
            'sms_valid_number' => count($valid_number),
            'sms_invalid_number' => count($invalid_number),
            'sms_cost' => $sms_cost,
            'numbers' => $GET_CSV,
            'is_confirmed' => $is_confirmed,
        ];
        return $this->respondWithSuccess('Bulk sms file fetch successfully',$data);
    }


    function isValidBangladeshPhoneNumber($phoneNumber)
    {
        $pattern = '/^(\+?88|01)?\d{11}$/';
        return preg_match($pattern, $phoneNumber);
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
