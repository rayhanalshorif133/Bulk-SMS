<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = User::orderBy('created_at', 'desc')->with('roles')->get();
             return DataTables::of($query)
             ->addIndexColumn()
             ->rawColumns(['action'])
             ->toJson();
            }
        return view('user.index');
    }

    public function keyGenerate(){
        $keyGenerate = $this->getUniqueApiKey();
        return $this->respondWithSuccess('Successfully genarate key', $keyGenerate);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email',  'min:8', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:25','confirmed'],
            'api_key' => ['required', 'string'],
        ]);

        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        try {
            $user = new User();
            $user->email =  $request->email;
            $user->password = Hash::make($request->password);
            $user->api_key =  $request->api_key;
            $user->status =  $request->status;
            $user->save();
            $user->syncRoles($request->role);
            flash()->addSuccess("User created successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }

    public function update(Request $request){

       

        if($request->password){
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email',  'min:8', 'max:255', 'unique:users,email,' . $request->id],
                'password' => ['string', 'min:8', 'max:25','confirmed'],
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email',  'min:8', 'max:255', 'unique:users,email,' . $request->id],
            ]);
        }
        
        if($validator->fails()) {
            flash()->addError($validator->errors()->first());
            return redirect()->back();
        }
        

        try {
            $user = User::find($request->id);
            $user->email =  $request->email;
            if($request->password){
                $user->password = Hash::make($request->password);
            }
            $user->api_key =  $request->api_key;
            $user->status =  $request->status;
            $user->save();
            $user->syncRoles($request->role);
            flash()->addSuccess("User updated successfully");
          } catch (\Exception $e) {
            flash()->addError($e->getMessage());
          }
          return redirect()->back();

    }


    public function fetchByName($name = null){
        if($name == null){
            $users = User::all();
        }else{
            $users = User::select()->where('name', 'LIKE', "%{$name}%")->get();
        }
        return $this->respondWithSuccess('Successfully fetched user',$users);
    }

    public function fetch($id){
        $user = User::select()->where('id',$id)
            ->with('roles')
            ->first();
        return $this->respondWithSuccess('Successfully fetched user',$user);
    }

    public function getUniqueApiKey()
    {
        $api_key = bin2hex(openssl_random_pseudo_bytes(10));
        $user = User::where('api_key', $api_key)->first();
        if ($user) {
            return $this->getUniqueApiKey();
        }
        return $api_key;
    }
}
