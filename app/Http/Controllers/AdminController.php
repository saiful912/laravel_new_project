<?php

namespace App\Http\Controllers;

use App\User;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            $data=$request->input();
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
//                session protect dashboard without login
//                Session::put('adminSession',$data['email']);
                return redirect(url('/admin/dashboard'));
            }else{
               return redirect('/admin')->with('flash_message_error','Invalid Username Or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard()
    {
//        session protect dashboard without login
//        if (Session::has('adminSession')){
//
//        }else{
//            return redirect('/admin')->with('flash_message_error','Please Login TO Access');
//        }
        return view('admin.dashboard');
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function check_password(Request $request)
    {
        $data=$request->all();
        $current_password=$data['current_pwd'];
        $check_password=User::where(['admin'=>'1'])->first();
        if (Hash::check($current_password,$check_password->password)){
            echo "true";die;
        }else{
            echo "false";die;
        }
    }
    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success','Admin Successfully logout');
    }
}
