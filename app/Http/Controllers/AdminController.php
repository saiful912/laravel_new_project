<?php

namespace App\Http\Controllers;

use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success','Admin Successfully logout');
    }
}
