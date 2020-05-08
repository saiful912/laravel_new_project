<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function view_coupon()
    {
        $coupons=Coupon::get();
        return view('admin.coupons.view_coupon',compact('coupons'));
    }
    public function add_coupon(Request $request)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            $coupon=new Coupon();
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->amount=$data['amount'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->status=$data['status'];
            $coupon->save();
            return redirect(url('/admin/view_coupon'))->with('flash_message_success','A new Coupon Added Successfully');
        }
        return view('admin.coupons.add_coupon');
    }

    public function edit_coupon(Request $request,$id=null)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            $coupon=Coupon::find($id);
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->amount=$data['amount'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->expiry_date=$data['expiry_date'];
            if (empty($data['status'])){
                $data['status']=0;
            }
            $coupon->status=$data['status'];
            $coupon->save();
            return redirect(url('/admin/view_coupon'))->with('flash_message_success','Coupon edit Successfully');
        }
        $couponDetails=Coupon::find($id);
        return view('admin.coupons.edit_coupon',compact('couponDetails'));
    }

    public function coupon_delete($id=null)
    {
        Coupon::where(['id'=>$id])->delete();
        return back()->with('flash_message_success','Coupon Deleted Successfully');
    }
}
