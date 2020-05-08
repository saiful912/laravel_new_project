<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $products=Product::get();
        $products=Product::orderBy('id','desc')->get();
        $products=Product::inRandomOrder()->where('status',1)->get();
        //get all categories
        $categories=Category::with('categories')->where(['parent_id'=>0])->get();

        //without relation
//        foreach ($categories as $cat){
//            echo $cat->name;
//            $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
//            foreach ($sub_categories as $sub_cat)
//            {
//                echo $sub_cat->name;echo "<br>";
//            }
//        }
        $banners=Banner::where('status',1)->get();
        return view('index',compact('products','categories','banners'));
    }
}
