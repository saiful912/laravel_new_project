<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;


class BannersController extends Controller
{
    public function add_banner(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $banner = new Banner();
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $banner_path = 'images/frontend_image/banner/' . $filename;

                    //resize image
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                    $banner->image = $filename;
                }
            }
            $banner->status = $status;
            $banner->save();
            return redirect(url('/admin/view_banner'))->with('flash_message_success', 'A Banner Successfully Added');
        }
        return view('admin.banner.add_banner');
    }

    public function view_banner()
    {
        $banners = Banner::get();
        return view('admin.banner.view_banner', compact('banners'));
    }

    public function edit_banner(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (empty($data['status'])) {
                $status = '0';
            } else {
                $status = '1';
            }
            if (empty($data['title'])) {
                $data['title'] = '';
            }
            if (empty($data['link'])) {
                $data['link'] = '';
            }
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $banner_path = 'images/frontend_image/banner/' . $filename;
                    //resize image
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                }
            } elseif (!empty($data['current_image'])) {
                $filename = $data['current_image'];
            } else {
                $filename = '';
            }
            Banner::where('id', $id)->update(['status' => $status, 'title' => $data['title'], 'link' => $data['link'],
                'image' => $filename]);
            return redirect(url('/admin/view_banner'))->with('flash_message_success', 'Banner Edit Successfully');
        }

        $bannerDetails = Banner::where('id', $id)->first();
        return view('admin.banner.edit_banner', compact('bannerDetails'));
    }

    public function banner_delete($id=null)
    {
        Banner::where(['id'=>$id])->delete();
        return back()->with('flash_message_success','Banner Deleted Successfully');
    }
}
