<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Balance;
use App\Models\SMSLog;
use App\Models\Credit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $today = date('Y-m-d');

        
        if(Auth::user()->roles[0]->name == 'user'){
            
            $getBalance = Balance::select()->where('user_id',Auth::user()->id)->first();
            $totalSmsSend = SMSLog::select()->where('user_id',Auth::user()->id)->whereDate('created_date_time',$today)->get();
            $today_portal_sent = SMSLog::select()->where('user_id',Auth::user()->id)->whereDate('created_date_time',$today)->where('type',1)->count();
            $today_api_sent = SMSLog::select()->where('user_id',Auth::user()->id)->whereDate('created_date_time',$today)->where('type',2)->count();
            $last_transaction = Credit::select()->where('user_id',Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $today_sent = $totalSmsSend->count();
            $last_transaction = $last_transaction? $last_transaction->amount : 0;
            $sms_balance = $getBalance? $getBalance->balance : 0;
            $today_portal_sent = $today_portal_sent? $getBalance->amount : 0;
            $today_api_sent = $today_api_sent ? $getBalance->amount : 0;
        }else{
            $today_sent = 0;
            $last_transaction = 0;
            $sms_balance = 0;
            $today_portal_sent = 0;
            $today_api_sent = 0;
        } 
        
        
        return view('dashboard', compact('sms_balance','today_api_sent','today_sent','today_portal_sent','last_transaction'));
    }
}
