<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    public function addportfolio(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'image' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validator->errors())], 400);
        }
        if (Auth('api')->user()->role_type == 2) {
            $user_id = Auth('api')->user()->id;
            $check = portfolio::where('user_id', $user_id)->latest('position')->first();
            if ($check) {
                $position = $check->position;
                foreach ($request->file('image') as $image) {
                    $position = $position + 1;
                    $file_name1 = $image->getClientOriginalName();
                    $folder_path1 = rand(100000, 1000000) . $file_name1;
                    $image->storeAs('public/portfolio', $folder_path1);
                    $path1 = 'portfolio/' . $folder_path1;
                    $data = new portfolio();
                    $data->user_id = $user_id;
                    $data->image  = $path1;
                    $data->position = $position;
                    $data->save();
                }
            } else {
                $i = 1;
                foreach ($request->file('image') as $image) {
                    $file_name2 = $image->getClientOriginalName();
                    $folder_path2 = rand(100000, 1000000) . $file_name2;
                    $image->storeAs('public/portfolio', $folder_path2);
                    $path2 = 'portfolio/' . $folder_path2;
                    $data = new portfolio();
                    $data->user_id = $user_id;
                    $data->image  = $path2;
                    $data->position = $i;
                    $data->save();
                    $i++;
                }
            }
            return response()->json(['status' => 200, 'message' => 'portfolio add successfull'], 200);

        }else{
            return response()->json(['status' => 400, 'message' => 'only add business'], 400);
        }
    }

    #------------- get portfilio ----------#
    public function getportfilio(Request $request)
    {
        dd('njnbbbvvvv');
        $data = portfolio::where('user_id', Auth('api')->user()->id)->get();
        return response()->json(['status' => 200, 'message' => 'List of Portifolio', 'data' => $data], 200);
    }
}
