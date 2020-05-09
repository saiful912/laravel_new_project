<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('post')){
//            $data=$request->all();
            //check if user already exists
//            $userCount=User::where('email',$data['email'])->count();
//            if ($userCount>0){
//                return back()->with('flash_message_error','Email Already Exists!');
//            }else{
//                echo 'success';die();
//            }
        }
        return view('user.login_register');
    }

    public function checkEmail(Request $request)
    {
        $data=$request->all();
        $userCount=User::where('email',$data['email'])->count();
        if ($userCount>0){
            echo 'false';
        }else{
            echo 'success';die();
        }
    }
}
