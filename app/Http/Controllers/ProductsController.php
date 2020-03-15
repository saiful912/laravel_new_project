<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {

        if($request->isMethod('post')){
            $data=$request->all();
            $product=new Product();
            if (empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Under Category is Missing');
            }
            $product->category_id=$data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            if (!empty($data['description'])){
                $product->description=$data['description'];
            }else{
                $product->description='';
            }

            $product->price=$data['price'];

            //upload Image
            if ($request->hasFile('image')){
                $image_tmp=Input::file('image');
                if ($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='images/backend_image/product/large/'.$filename;
                    $medium_image_path='images/backend_image/product/medium/'.$filename;
                    $small_image_path='images/backend_image/product/small/'.$filename;
                    //resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    $product->image=$filename;
                }
            }
            $product->save();
            return back()->with('flash_message_success','A Product Successfully Added');
        }
        //category categories_dropdown start
        $categories=Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option selected disabled>Select</option>";
        foreach ($categories as $cat){
            $categories_dropdown .="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat){
                $categories_dropdown .="<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        //category categories_dropdown end
        return view('admin.products.add_product',compact('categories_dropdown'));
    }

    public function view_product()
    {
        $products=Product::get();
        foreach ($products as $key =>$val){
            $category_name=Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name=$category_name->name;
        }
        return view('admin.products.product_view',compact('products'));
    }

    public function edit_product(Request $request,$id=null)
    {
        if ($request->isMethod('post')){
            $data=$request->all();

            //upload Image
            if ($request->hasFile('image')){
                $image_tmp=Input::file('image');
                if ($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='images/backend_image/product/large/'.$filename;
                    $medium_image_path='images/backend_image/product/medium/'.$filename;
                    $small_image_path='images/backend_image/product/small/'.$filename;
                    //resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                }
            }   else{
                $filename=$data['current_image'];
            }
            if (empty($data['description'])){
                $data['description']="";
            }

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],
                'price'=>$data['price'],'image'=>$filename]);
            return redirect('/admin/view_product')->with('flash_message_success','Product Has Been Updated');
        }

        $productDetails=Product::where(['id'=>$id])->first();
        //category categories_dropdown start
        $categories=Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option selected disabled>Select</option>";
        foreach ($categories as $cat){
            if ($cat->id==$productDetails->category_id){
                $selected="selected";
            }else{
                $selected="";
            }
            $categories_dropdown .="<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat){
                if ($sub_cat->id==$productDetails->category_id){
                    $selected="selected";
                }else{
                    $selected="";
                }
                $categories_dropdown .="<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        //category categories_dropdown end
        return view('admin.products.edit_product',compact('productDetails','categories_dropdown'));
    }

    public function delete_product_image($id=null)
    {
        Product::where(['id'=>$id])->update(['image'=>'']);
        return back()->with('flash_message_success','Image Deleted');
    }
}