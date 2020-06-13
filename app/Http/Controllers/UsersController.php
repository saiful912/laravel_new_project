<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function userLoginregister()
    {
        return view('user.login_register');
    }
    public function register(Request $request)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
//            check if user already exists
            $userCount=User::where('email',$data['email'])->count();
            if ($userCount>0){
                return back()->with('flash_message_error','Email Already Exists!');
            }else{
                $user=new User();
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=bcrypt($data['password']);
                $user->save();
                if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);
                    if (!empty(Session::get('session_id'))){
                        $session_id=Session::get('session_id');
                        DB::table('carts')->where('session_id',$session_id)->update(['user_email'=>$data['email']]);
                    }
                    return redirect(url('/cart'));
                }
            }
        }
        return view('user.login_register');

    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                Session::put('frontSession',$data['email']);
                if (!empty(Session::get('session_id'))){
                    $session_id=Session::get('session_id');
                    DB::table('carts')->where('session_id',$session_id)->update(['user_email'=>$data['email']]);
                }
                return redirect(url('/cart'));
            }else{
                return back()->with('flash_message_error','Invalid Username or Password');
            }
        }
    }

    public function account(Request $request)
    {
        $user_id=Auth::user()->id;
        $userDetails=User::find($user_id);
        $countries=Country::get();
        if($request->isMethod('post')){
            $data=$request->all();
            $user=User::find($user_id);
            $user->name=$data['name'];
            $user->address=$data['address'];
            $user->city=$data['city'];
            $user->state=$data['state'];
            $user->country=$data['country'];
            $user->pincode=$data['pincode'];
            $user->mobile=$data['mobile'];
            $user->email=$data['email'];
            $user->save();
            return back()->with('flash_message_success',"Your Account has been successfully Updated");
        }
        return view('user.account',compact('countries','userDetails'));
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('frontSession');
        return redirect(url('/'));
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
    
    //check user password
    public function check_password(Request $request)
    {
        $data=$request->all();
        $current_password=$data['current_pwd'];
        $user_id=Auth::user()->id();
        $check_password=User::where('id',$user_id)->first();
        if (Hash::check($current_password,$check_password->password)){
            echo "true";die;
        }else{
            echo "false";die;
        }
    }
    //update password
    public function update_password(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->all();
            $old_pwd=User::where('id',Auth::user()->id)->first();
            $current_password=$data['current_pwd'];
            if (Hash::check($current_password,$old_pwd->password)){
                $new_pwd=bcrypt($data['new_password']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return back()->with('flash_message_success','Password Update Successfully!');
            }else{
                return redirect()->back()->with('flash_message_error','Current Password is Incorrect!');
            }

        }
    }
}
