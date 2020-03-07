<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $id = $request->id;
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
                'role' => 2,
                'deletado' => false
            ]);
            $user->save();
                
            return \response()->json(['status'=>'success'],200);
        }
        catch(\Exception $error){
            throw new \Exception('fail to create a user: '. $error);
        }
    }

    public function update(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:4',
                'email'=>'required',
                'password'=>'required|min:5'
            ]);
                
            if($validator->fails())
            return \response()->json([
                'status' =>'error',
                'errors' => $validator->errors()
            ], 422);

            $id = $request->id;
            $user = User::find($id)->where(['deletado'=>false])->first();
            $idByEmailRequest = DB::table('users')->select('id')->where(['email'=>$request->email])->first();
            if($idByEmailRequest != null){
                if($id != $idByEmailRequest->id)
                    return \response()->json(['status'=>'error','errors'=>['email'=>'Email inválido ou já está em uso por outro usuário']],422);
            }

            User::where(['id'=> $id])->update([
                'name'=>$request->name,
                'email' => $request->email,
                'password'=> \bcrypt($request->password)
            ]);
            
            return \response()->json(['status'=>'success'],200);
        }
        catch(\Exception $error){
            throw new \Exception('fail to create a user: '. $error);
        }
    }
    
    public function delete(Request $request){
        try{
            $id = $request->id;
            $user = User::where(['id'=> $id])->update(['deletado'=>true]);
                
            return \response()->json(['status'=>'success'],200);
        }
        catch(\Exception $error){
            throw new \Exception('fail to delete a user: '. $error);
        }
    }

    public function list(){
        try{
            $users = User::where(['deletado'=>false])->get();
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
            $user = User::find($request->id);
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
