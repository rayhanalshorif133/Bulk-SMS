<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Fund;
use Illuminate\Support\Facades\Validator;

class FundController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = Fund::orderBy('created_at', 'desc')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('fund.index');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string',  'min:1', 'max:255', 'unique:funds'],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        try {
            $fund = new Fund();
            $fund->name =  $request->name;
            $fund->save();
            flash()->addSuccess("Fund created successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }

    public function update(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string',  'min:1', 'max:255', 'unique:funds,name,' . $request->id],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        try {
            $fund = Fund::find($request->id);
            $fund->name =  $request->name;
            $fund->save();
            flash()->addSuccess("Fund updated successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }


    public function fetch($id){
        $fund = Fund::find($id);
        return $this->respondWithSuccess('Successfully fetched fund',$fund);
    }

    public function delete($id){
        try{
            $fund = Fund::find($id);
            $fund->delete();
            return $this->respondWithSuccess('Fund deleted successfully');
        } catch (\Exception $e) {
            return $this->respondWithError('Something went wrong.!',$e->getMessage());
        }
    }
}
