<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SenderInfo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SenderInfoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){

        if(Auth::user()->roles[0]->name == 'user'){
            if (request()->ajax()) {
                $query = SenderInfo::orderBy('created_at', 'desc')
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
                $query = SenderInfo::orderBy('created_at', 'desc')
                    ->with('user')
                    ->get();
                 return DataTables::of($query)
                 ->addIndexColumn()
                 ->rawColumns(['action'])
                 ->toJson();
            }
        } 

        

        $users = User::whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            })->get();


        return view('sender-info.index', compact('users'));
    }

    public function fetch($id){
        $senderInfo = SenderInfo::select()->where('id',$id)->with('user')->first();
        return $this->respondWithSuccess('Successfully fetch sender info', $senderInfo);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'sender_id' => ['required', 'string',  'min:8', 'max:255', 'unique:sender_infos'],
            'api_key' => ['required', 'string', 'min:5', 'max:255','unique:sender_infos'],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        

        try {
            $senderInfo = new SenderInfo();
            $senderInfo->user_id =  $request->user_id;
            $senderInfo->sender_id =  $request->sender_id;
            $senderInfo->api_key =  $request->api_key;
            $senderInfo->save();
            flash()->addSuccess("Sender Info created successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'sender_id' => ['required', 'string',  'min:8', 'max:255', 'unique:sender_infos,sender_id,' . $request->id],
            'api_key' => ['required', 'string', 'min:5', 'max:255'],
        ]);


        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        

        try {
            $senderInfo = SenderInfo::find($request->id);
            $senderInfo->user_id =  $request->user_id;
            $senderInfo->sender_id =  $request->sender_id;
            $senderInfo->api_key =  $request->api_key;
            $senderInfo->save();
            flash()->addSuccess("Sender Info created successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }

    public function senderIdGenerate(){
        $senderID = $this->generateRandomString(20);
        $senderInfoFind = SenderInfo::select()->where('sender_id',$senderID)->first();
        if($senderInfoFind){
            $this->senderIdGenerate();
        }
        return $this->respondWithSuccess('Successfully genarate sender id', $senderID);
    }

    
    function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function delete($id){
        try{
            $senderInfo = SenderInfo::find($id);
            $senderInfo->delete();
            return $this->respondWithSuccess('Sender Info deleted successfully');
        } catch (\Exception $e) {
            return $this->respondWithError('Something went wrong.!',$e->getMessage());
        }
    }
}
