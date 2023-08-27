<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\thread;
use App\models\media;
use App\Models\message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


#--------------- add message -----------------#
class ChatController extends Controller
{
    public function add_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|integer',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validator->errors())], 400);
        }
        $check = thread::where('sender_id', Auth('api')->user()->id)->where('receiver_id', $request->receiver_id)
            ->orwhere('sender_id', $request->receiver_id)->where('receiver_id', Auth('api')->user()->id)->first();
        if ($request->type == 1) {
            if (!$check) {
                $data = new thread();
                $data->sender_id    =   Auth('api')->user()->id;
                $data->receiver_id  =   $request->receiver_id;
                $data->last_message =   $request->message;
                $data->message_type =   $request->type;
                $data->save();
            } else {
                $id = $check->id;
                $data = thread::find($id);
                $data->sender_id    =   Auth('api')->user()->id;
                $data->receiver_id  =   $request->receiver_id;
                $data->last_message =   $request->message;
                $data->message_type =   $request->type;
                $data->save();
            }
            $thread_id = $data->id;
            $data = new message();
            $data->thread_id = $thread_id;
            $data->sender_id = Auth('api')->user()->id;
            $data->receiver_id = $request->receiver_id;
            $data->message     = $request->message;
            $data->message_type = $request->type;
            $data->save();
            $last_data = thread::find($thread_id);
            return response()->json(['status' => 200, 'message' => 'chat add successfull', 'data' => $last_data], 200);
        }

        if ($request->type == 2 || $request->type == 3 || $request->type == 4) {
            if (!$check) {
                $data = new thread();
                $data->sender_id     = Auth('api')->user()->id;
                $data->receiver_id   = $request->receiver_id;
                $data->last_message  = null;
                $data->message_type  = $request->type;
                $data->save();
            } else {
                $id = $check->id;
                $data = thread::find($id);
                $data->sender_id     = Auth('api')->user()->id;
                $data->receiver_id   = $request->receiver_id;
                $data->last_message  = null;
                $data->message_type  = $request->type;
                $data->save();
            }
            $message = new message();
            $message->thread_id   = $data->id;
            $message->sender_id   = Auth('api')->user()->id;
            $message->receiver_id = $request->receiver_id;
            $message->message     = null;
            $message->message_type = $request->type;
            $message->save();
            foreach ($request->media as $media) {
                $file_name1 = $media->getClientOriginalName();
                $folder_path1 = rand(100000, 1000000) . $file_name1;
                $media->storeAs('public/media', $folder_path1);
                $path1 = 'media/' . $folder_path1;
                $media = new media();
                $media->message_id = $message->id;
                $media->media      = $path1;
                $media->save();
            }
            return response()->json(['status' => 200, 'message' => 'media add successfull'], 200);
        }
    }

    #---------------- Message List -----------------#

    public function message_list(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'receiver_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validation->errors())], 400);
        }

        $message_list = message::where('sender_id', Auth('api')->user()->id)->where('receiver_id', $request->receiver_id)
            ->orwhere('sender_id', $request->receiver_id)->where('receiver_id', Auth('api')->user()->id)->with('media')
            ->orderBy('id','desc');
          
        if (isset($request->limit) && !empty($request->limit)) 
        {
            $data = $message_list->paginate($request->limit);
        } 
        else 
        {
            $data = $message_list->paginate(10);
        }
        return response()->json(['status' => 200, 'message' => 'message list', 'data' => $data], 200);
    }
    
    public function user_block(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'receiver_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => getErrorAsString($validation->errors())], 400);
        }
          $check = thread::where('sender_id', Auth('api')->user()->id)->where('receiver_id', $request->receiver_id)
            ->orwhere('sender_id', $request->receiver_id)->where('receiver_id', Auth('api')->user()->id)->first();
            if($request->type ==1)
            {
               if($check->blocked_user1 ==0)
               { 
                  thread::where('id',$check->id)->update(['blocked_user1'=>auth('api')->user()->id]);
               }
               else{
                thread::where('id',$check->id)->update(['blocked_user1'=>auth('api')->user()->id]);
               }
               return response()->json(['status'=>200,'message'=>'user blocked sucessfully']);
            }
            if($request->type == 2)
            {
                if($check->blocked_user1 == auth('api')->user()->id)
                {
                  thread::where('id',$check->id)->update(['blocked_user1'=>0]);
                }
                if($check->blocked_user2 == auth('api')->user()->id)
                {
                    thread::where('id',$check->id)->update(['blocked_user1'=>0]);
                }
                return response()->json(['status'=>200,'message'=>'user Unblocked successfully']);
            }
    }




public function getData()
{

    $data = DB::table('user_tb')
    ->join('cource_tb','user_tb.cource_id','=','cource_tb.id')->get();

    return response()->json(['status'=>200,'data'=>$data]);

}
}



