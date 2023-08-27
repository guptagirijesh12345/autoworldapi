<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\service_category;
use App\Models\service; 
class ServiceController extends Controller
{
    public function service_category()
    {
        $service_category = service_category::all();
        return response()->json(['status'=>200,'message'=>'list service category','data'=>$service_category],200);
    }

    public function getservice(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'service_category_id'=>'required'
        ]);
        if($validation->fails())
        {
            return response()->json(['status'=>400,'message'=>getErrorAsString($validation->errors())],400);
        }
        $service = service::where('service_category_id',$request->service_category_id)->get();
        return response()->json(['status'=>200,'message'=>'list of service','data'=>$service],200);
    }
}
