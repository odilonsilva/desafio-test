<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:4',
                'email' =>'required|email|unique:users',
                'password'=>'required|min:5'
            ]);

            if($validator->fails())
                return \response()->json([
                    'status' =>'error',
                    'errors' => $validator->errors()
                ], 422);
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \bcrypt($request->password),
                'role' => 2
            ]);
            $user->save();
                
            return \response()->json(['status'=>'success'],200);
        }
        catch(\Exception $error){
            throw new \Exception('fail to create a user: '. $error);
        }
    }

    public function list(){
        try{
            $users = User::all();
            return response()->json(['status'=>'success','data'=>$users]);
        }
        catch(\Exception $error){
            throw new \Exception("Error Processing Request", $error);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if($token = $this->guard()->attempt($credentials))
            return \response()->json(['status'=>'success','token'=>$token],200)->header('Authorization',$token);
            
        return \response()->json(['error'=>'login_error'],401);
    }

    public function logout(Request $request){
        $this->guard()->logout();
          return \response()->json(['status'=>'success'],200);
    }

    public function user(Request $request){
        try{
            $user = User::find(Auth::user()->id);
            return \response()->json(['status'=>'success','data'=> $user],200);
        }
        catch(\Exception $error){
            throw new \Exception('falha ao busca usuário '. $error);
        }
    }
    
    public function refresh(Request $request){
        if($token = $this->guard()->refresh())
            return \response()->json(['status'=>'success'],200)
            ->header('Authorization',$token);

        return \response()->json(['error'=>'refresh_error']);
    }
    
    private function guard(){
        return Auth::guard();
    }
}
