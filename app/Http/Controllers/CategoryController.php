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
            $category->parent_id=$data['parent_id'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->save();
            return redirect()->back()->with('flash_message_success','Category Added Successfully');
        }
        $levels =Category::where(['parent_id'=>0])->get();
        return view('admin.categories.add_category',compact('levels'));
    }

    public function update_category(Request $request,$id=null)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            Category::where(['id'=>$id])->update(['name'=>$data['name'],'parent_id'=>$data['parent_id'],'description'=>$data['description'],'url'=>$data['url']]);
            return redirect('/admin/view_categories')->with('flash_message_success','Category Updated Successfully');
        }
        $category=Category::where(['id'=>$id])->first();
        $levels =Category::where(['parent_id'=>0])->get();
        return view('admin.categories.edit_category',compact('category','levels'));
    }

    public function delete_category(Request $request,$id=null)
    {
        if (!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Category Successfully Delete');
        }
    }

}
