<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendSMSController extends Controller
{
    // http://localhost:3000/api/sendsms?api_key=sadmcuelkams9&mobile_number=+8801323174104&text=hello%20world
    public function sendSMS(Request $request)
    {
        dd($request->all());
    }
}
