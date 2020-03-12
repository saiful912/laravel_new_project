<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function view_category()
    {
        $categories=Category::get();
        return view('admin.categories.view_category',compact('categories'));
    }
    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            $category=new Category();
            $category->name=$data['name'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->save();
            return redirect()->back()->with('flash_message_success','Category Added Successfully');
        }
        return view('admin.categories.add_category');
    }


}
