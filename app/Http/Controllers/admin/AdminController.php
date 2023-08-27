<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{

  #------- login ---------#

  public function login()
  {

    return view('admin.login');
  }

  #------------ admin Login --------------#
  public function Login_data(Request $request)
  {
    //dd('sknsnksnkskn');
   // dd($request->all());

    $request->validate([

      'email' => 'required|email',
      'password' => 'required',

    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
         //dd(Auth::attempt(['email' => $request->email, 'password' => $request->password]));
        // echo Auth::user();die();
      return redirect('home');
    } else {
      //echo 'khkhkkh';
      return redirect('admin.login');
    }
  }

  #----------  logout -----------#

  public function logout()
  {

    Auth::logout();
    return redirect('admin.login');
  }

  #----------- Home --------------#
  public function home()
  {
    return view('admin.home');
  }

  #------------ profile -----------------#
  public function profile()
  {

    $data = User::where('id', Auth::id())->first();

    return view('admin.profile', ['data' => $data]);
  }

  #----------------- user ---------------#
  public function user(Request $request)
  {

    if ($request->ajax()) {
      $data = User::where('role_type', 1)->get();
      return Datatables::of($data)->addIndexColumn()

        ->addColumn('image', function ($row) {
          if ($row->image != "") {
            $img = '<div><img src="' . asset('storage/' . $row->image) . '" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%" /></div>';
          } else {
            $img = '<div><img src="' . asset('dummy/dumm_image.png') . '" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%"></div>';

          }
          return $img;
        })
        ->addColumn('action', function ($row) {
          $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
          return $btn;
        })
        ->addColumn('softdelete', function ($row) {
          $btn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm">softdelete</a>';
          return $btn;
        })
        ->rawColumns(['image', 'action', 'softdelete'])->make(true);
    }
    return view('admin.user');
  }
  #----------------- business ---------------#
  public function business(Request $request)
  {
    if ($request->ajax()) {
      if(!empty($request->sdate) && !empty($request->edate))
      {
        $data = User::whereBetween('created_at',[$request->sdate,$request->edate])->where('role_type', 2)->get();

      }
      else{
      $data = User::where('role_type', 2)->get();
      }
      return Datatables::of($data)->addIndexColumn()
        ->addColumn('image', function ($row) {
          if ($row->image != "") {
            // $url= asset('storage/'.$row->image);
            $img = '<div><img src="' . asset('storage/' . $row->image) . '" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%"></div>';
          } else {
            // $img = '<div><img src="' . asset('dummy/dumm_image.png') . '" border="0" width="60" class="img-rounded" align="center" /></div>';
            $img = '<div><img src="' . asset('dummy/dumm_image.png') . '" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%"></div>';
    
          }
          return $img;
        })
        ->addColumn('action', function ($row) {
          $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
          return $btn;
        })
        ->rawColumns(['image', 'action'])->make(true);
    }
    return view('admin.business');
  }

  #------ change password admin -------#
  public function changePass(Request $request)
  {
    if (Hash::check($request->opassword, Auth::user()->password)) {
      if ($request->npassword == $request->cpassword) {
        User::where('id', Auth::id())->update(['password' => Hash::make($request->npassword)]);
        echo 1;
      } else {
        echo 2;
      }
    } else {
      echo 3;
    }
  }


  public function img()
  {
    return view('img');
  }
  public function check_email(Request $request)
  {
    $request->validate([
      'email' => 'required|email|unique:users,email',
  ]);
  return response()->json(['success' => true]);
  }
}
