<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\TwilioTrait;
use App\Models\Code;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    use TwilioTrait;
    public function __construct() {
        $this->middleware('auth:web', ['except' => ['login','register']]);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|exists:users,mobile_number',
            'password' => 'required',
        ],[
            'mobile_number.required' =>'mobile number Required ',
            'password.required' =>' Password Required ',
            'password.min'=>'This password is Very Short',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'status'=> 422]);
        }
        if(!$token = auth()->guard('web')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if(auth()->guard('web')->attempt([
            'mobile_number' => $request->mobile_number,
            'password' => $request->password,
            'email_verified_at'=>null
        ])){
            $otp=mt_rand(100000, 999999);
            Code::create([
                'user_id'=>auth('web')->user()->id,
                'code'=>$otp,
            ]);
            $this->sendsms('+20'.$request->mobile_number,$otp);
            return response()->json(['message'=>'Your Verification Code Sent .Please verify Your Number . . . ','token'=>$token,'status'=> 422]);

        }

        if(auth()->guard('web')->attempt([
            'mobile_number' => $request->mobile_number,
            'password' => $request->password,
        ])){

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->guard('web')->factory()->getTTL() * 60,
                'user' => auth('web')->user(),
            ]);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'mobile_number'=>'required|numeric|unique:users,mobile_number',
            'password' => 'required|confirmed|min:6',
        ]

        );
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'status'=> 422]);
        }
        try{
            DB::beginTransaction();
            $user=User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' =>Hash::make($request->password),
                'mobile_number' => $request->mobile_number,
            ]);

            $token = Auth::login($user);
            $otp=mt_rand(100000, 999999);
            Code::create([
                'user_id'=>auth('web')->user()->id,
                'code'=>$otp,
            ]);
            $this->sendsms('+20'.$request->mobile_number,$otp);
            DB::commit();
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user,
                'token' =>$token
            ], 201);
        }catch(Exception $ex){
            DB::rollback();
            return $ex;
        }

    }
    public function logout(Request $request){
        auth('web')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function profile(Request $request){

        return response()->json([
            'profile' => auth('web')->user(),
        ], 201);

    }
    public function verify(Request $request){
        $validator = Validator::make($request->all(), [
            'code'=>'required|numeric|exists:codes,code',
        ]

        );
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'status'=> 422]);
        }
        try{
            DB::beginTransaction();
            $code=Code::where('user_id',auth('web')->user()->id)->where('code',$request->code)->first();
            $user=User::findOrFail(auth('web')->user()->id);
            if($code){
                $user->email_verified_at=now();
                $code=Code::where('user_id',auth('web')->user()->id)->delete();
                $user->save();
                DB::commit();
                return response()->json(['message' => 'Successfully  Verified']);
            }
            return response()->json(['message' => 'Invalid Code']);
        }catch(Exception $ex){
            DB::rollBack();
            return $ex;
        }


    }
}
