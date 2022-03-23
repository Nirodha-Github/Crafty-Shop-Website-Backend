<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;
use App\Http\Middleware\Auth;


class AuthController extends Controller
{

    public function register(Request $request){
        $validator = validator::make($request->all(),[
            'fname'=>'required|max:191',
            'lname'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users,email',
            'phoneno'=>'required|max:10',
            'password'=>'required|min:8',
            'address'=>'required|max:191',
            
        ]);

        if($validator->fails()){
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else{
            $user = User::create([
                'firstname'=>$request->fname,
                'lastname'=>$request->lname,
                'email'=>$request->email,
                'phoneno'=>$request->phoneno,
                'address'=>$request->address,
                'password'=>Hash::make($request->password),
                
            ]);

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status'=>200,
                'username'=>$user->firstname." ".$user->lastname,
                'id'=>$user->id,
                'token'=>$token,
                'message'=>'Registered Successfully',
                ]);
        }
    }

    public function login(Request $request){
        $validator = validator::make($request->all(),[
            'email'=>'required|max:191',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else{

             $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials',
                ]);                
            }
            else{

                if($user -> role_as == 1){
                    //1=Admin
                    $role= 'admin';
                    $token = $user->createToken($user->email.'_AdminToken',['server:admin'])->plainTextToken;
                 
                }
                else{
                    $role = '';
                    $token = $user->createToken($user->email.'_Token',[''])->plainTextToken;
                }

                return response()->json([
                    'status'=>200,
                    'username'=>$user->firstname." ".$user->lastname,
                    'id'=>$user->id,
                    'token'=>$token,
                    'message'=>'Logged Successfully',
                    'role' => $role,
                    ]);                
            }
            
        }
    }

    public function logout()
    {
       auth()->user()->tokens()->delete();
       return response()->json([
         'status'=>200,
         'message'=>'Logged Out Successfully',
       ]);
    }

}
