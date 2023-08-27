<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\service_category;
use App\Models\service;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
 
class ServiceController extends Controller
{

  #-------- show service category -----------#
  public function service_category(Request $request)
  {
    if ($request->ajax()) {
      $data = service_category::all();
      return Datatables::of($data)->addIndexColumn()
        ->addColumn('image', function ($row) {
          if ($row->image != "") {
            // $url= asset('storage/'.$row->image);
            $img = '<div><img src="' . asset('storage/' . $row->image) . '"  style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%" /></div>';
          } else {
            $img = '<div><img src="' . asset('dummy/dumm_image.png') . '" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%"></div>';

          }
          return $img;
        })
        ->addColumn('action', function ($row) {
          // $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
          $btn = '<a href="' . route("service", [Crypt::encryptString($row->id)]) . '" class=" view btn btn-primary btn-sm">View</a>';
          return $btn;
        })

        ->addColumn('status', function ($row) {
          if ($row->status == 1)
            $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Active</a>';
          else {
            $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">NonActive</a>';
          }
          return $btn;
        })
        ->rawColumns(['image', 'status', 'action'])->make(true);
    }

    return  view('admin.service_category');
  }

  #---------- add service --------#
  public function addService_category(Request $request)
  {
    $data = new service_category();
    $data->name = $request->category;
    $file_name1 = $request->file('file')->getClientOriginalName();
    $folder_path1 = rand(100000, 1000000) . $file_name1;
    $request->file('file')->storeAs('public/serviceImage', $folder_path1);
    $path1 = 'serviceImage/' . $folder_path1;
    $data->image = $path1;
    $data->save();
    if ($data) {
      echo 1;
    } else {
      echo 2;
    }
  }
  

  // $btn = '<a href="' . route("service", [$row->id]) . '" class=" view btn btn-primary btn-sm">View</a>';


  public function service(Request $request,$id)
  {  
    
    $data = Service::where('service_category_id',Crypt::decryptString($id))->paginate(5);
    // $data = DB::table('Services')->where('service_category_id',$id)->paginate(10);
    return view('admin.service',['data'=>$data]);
  }


  public function addService(Request $request)
  {
    $data = new service();
    $data->service_category_id = $request->id;
    $data->service_name = $request->service;
    $file_name1 = $request->file('file')->getClientOriginalName();
    $folder_path1 = rand(100000, 1000000) . $file_name1;
    $request->file('file')->storeAs('public/serviceImage', $folder_path1);
    $path1 = 'serviceImage/' . $folder_path1;
    $data->image = $path1;
    $data->save();
    if ($data) {
      echo 1;
    } else {
      echo 2;
    }
  }
  
} 
  