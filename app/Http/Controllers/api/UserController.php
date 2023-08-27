<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserController extends Controller
{
    #---------  User Signup ----------#
    public function userSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'mobile' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required',
            'role_type' => 'required|numeric',
            'device_type' => 'required|numeric',
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validator->errors())], 400);
        }
        $check  = User::where('email', $request->email)->first();
        if ($check) {
            return response()->json(['status' => 400, 'message' => 'email already exists'], 400);
        } else {
            $data = new User();
            $data->name   = $request->name;
            $data->email  = $request->email;
            $data->password   = Hash::make($request->password);
            $data->mobile   = $request->mobile;
            $data->gender   = $request->gender;
            $data->address   = $request->address;
            $data->country_id   = $request->country_id;
            $data->state_id   = $request->state_id;
            $data->city_id   = $request->city_id;
            $data->latitude   = $request->latitude;
            $data->longitude   = $request->longitude;
            $data->role_type   = $request->role_type;
            $data->device_type   = $request->device_type;
            $data->device_token   = $request->device_token;
            $data->save();
            $result = User::find($data->id);
            if($request->role_type==2)
            {
             workingday($data->id);
            }
            $token = $data->createToken('autoworld')->accessToken;
            $result['token'] = $token;
            return response()->json(['status' => 200, 'message' => 'registration sucessfully', 'data' => $result], 200);
        }
    }

    #---------- User Login --------------#
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'device_type' => 'required|numeric',
            'device_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validator->errors())], 400);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $id = Auth::User()->id;
            $updateData = User::find($id);
            $updateData->device_type = $request->device_type;
            $updateData->device_token = $request->device_token;
            $updateData->latitude = $request->latitude;
            $updateData->longitude = $request->longitude;
            $updateData->save();
            $result = user::find($id);
            $token = $updateData->createToken('autoworld')->accessToken;
            $result['token'] = $token;
            return response()->json(['status' => 200, 'message' => 'registration sucessfully', 'data' => $result], 200);
        } else {
            return response()->json(['status' => 400, 'message' => 'email or password not matched'], 400);
        }
    }

    #-----------  user logout  ---------#
    public function user_logout(Request $request)
    {
        // $id = auth()->id();
        // $data = User::find($id);
        // $data->device_type = "";
        // $data->device_token = "";
        // $data->save();
        auth()->user()->tokens()->delete();
        return response()->json(['status' => 200, 'message' => 'Logout Successfully'], 200);
    }

    #------------ update profile ----------#
    public function update_profile(Request $request)
    {
        $id = Auth::id();
        $data = User::find($id);
        if (!empty($request->name) && isset($request->name)) {
            $data->name = $request->name;
        }
        if (!empty($request->moblie) && isset($request->mobile)) {
            $data->mobile = $request->mobile;
        }
        if (!empty($request->address) && isset($request->address)) {
            $data->address = $request->address;
        }
        if (!empty($request->image) && isset($request->image)) {
            $file_name1 = $request->file('image')->getClientOriginalName();
            $folder_path1 = rand(100000, 1000000) . $file_name1;
            $request->file('image')->storeAs('public/image', $folder_path1);
            $path1 = 'image/' . $folder_path1;
        }

        $data->image = $path1 ?? $data->image;
        if (!empty($request->cover_image) && isset($request->cover_image)) {
            $file_name2 = $request->file('cover_image')->getClientOriginalName();
            $folder_path2 = rand(100000, 1000000) . $file_name2;
            $request->file('cover_image')->storeAs('public/image', $folder_path2);
            $path2 = 'image/' . $folder_path2;
        }
        $data->cover_image = $path2 ?? $data->cover_image;
        $data->save();
        $result = User::find($data->id);
        return response()->json(['status' => 200, 'message' => 'update profile successful', 'data' => $result], 200);
    }

    #------- social login -----------#
    public function social_login(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'social_id' => 'required',
            'social_type' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validation->errors())], 400);
        }
        $social_id = User::where('social_id', $request->social_id)->first();
        if ($social_id) {
            $email = User::where('email', $request->email)->first();
            if ($email) {
                $data = User::where('email', $request->email)->update([
                    'social_id' => $request->social_id,
                    'social_type' => $request->social_type,
                    'device_type' => $request->device_type,
                    'device_token' => $request->device_token,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]); 
                 $id = $email->id;

            } else {
                $data = new User();
                $data->social_id = $request->social_id;
                $data->social_type = $request->social_type;
                $data->device_type = $request->device_type;
                $data->device_token = $request->device_token;
                $data->latitude     = $request->latitude;
                $data->longitude    = $request->longitude;
                $data->save();
                $id = $data->id;
              }
            }
         else {

            $data = new User();
            $data->social_id = $request->social_id;
            $data->social_type = $request->social_type;
            $data->device_type = $request->device_type;
            $data->device_token = $request->device_token;
            $data->latitude     = $request->latitude;
            $data->longitude    = $request->longitude;
            $data->save();
            $id = $data->id;
        }
        $result = User::find($id);
        $token = $result->createToken('autoworld')->accessToken;
        $result['token'] = $token;
        return response()->json(['status'=>200,'message'=>'socila login successfully','data'=>$result],200);
    }

    # -------- get countries --------------#
    public function getcountry()
    {
        $country = DB::table('countries')->get();
        return response()->json(['status'=>200,'message'=>'List of contries','data'=>$country],200);
    }

    #-----------get state ------------ #
    public function getstate(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'country_id'=>'required'
        ]);
        if($validation->fails())
        {
            return response()->json(['status'=>400,'message'=>getErrorAsString($validation->errors())],400);
        }
         $check = DB::table('states')->where('country_id',$request->country_id)->exists();
         if($check){
            $states = DB::table('states')->where('country_id',$request->country_id)->get();
            return response()->json(['status'=>200,'message'=>'list of states','data'=>$states],200);
         }
         else{
            
            return response()->json(['status'=>400,'message'=>'nothing states'],400);
         }
    }
    #---------- get city ---------#
    public function getcity(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'state_id'=>'required'
        ]);
        if($validation->fails())
        {
            return response()->json(['status'=>400,'message'=>getErrorAsString($validation->errors())],400);
        }
         $check = DB::table('cities')->where('state_id',$request->state_id)->exists();
         if($check){
            $cities = DB::table('cities')->where('state_id',$request->state_id)->get();
            return response()->json(['status'=>200,'message'=>'list of cities','data'=>$cities],200);
         }
         else{
             return response()->json(['status'=>400,'message'=>'nothing cities'],400);
         }

    }

}

