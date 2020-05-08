<?php

namespace App\Http\Controllers;

use App\Category;
use App\Coupon;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use DemeterChain\C;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    public function addProduct(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $product = new Product();
            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error', 'Under Category is Missing');
            }
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }
            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }

            $product->price = $data['price'];

            //upload Image
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_image/product/large/' . $filename;
                    $medium_image_path = 'images/backend_image/product/medium/' . $filename;
                    $small_image_path = 'images/backend_image/product/small/' . $filename;
                    //resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(500, 642)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 385)->save($small_image_path);
                    $product->image = $filename;
                }
            }
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            $product->status = $status;
            $product->save();
            return back()->with('flash_message_success', 'A Product Successfully Added');
        }
        //category categories_dropdown start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach ($categories as $cat) {
            $categories_dropdown .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value='" . $sub_cat->id . "'>&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }
        //category categories_dropdown end
        return view('admin.products.add_product', compact('categories_dropdown'));
    }

    public function view_product()
    {
        $products = Product::orderBy('id', 'desc')->get();
        foreach ($products as $key => $val) {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.product_view', compact('products'));
    }

    public function edit_product(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            //upload Image
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_image/product/large/' . $filename;
                    $medium_image_path = 'images/backend_image/product/medium/' . $filename;
                    $small_image_path = 'images/backend_image/product/small/' . $filename;
                    //resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                }
            } else {
                $filename = $data['current_image'];
            }
            if (empty($data['description'])) {
                $data['description'] = "";
            }
            if (empty($data['care'])) {
                $data['care'] = "";
            }
            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }

            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => $data['product_name'],
                'product_code' => $data['product_code'], 'product_color' => $data['product_color'], 'description' => $data['description'],
                'care' => $data['care'], 'price' => $data['price'], 'status' => $status, 'image' => $filename]);
            return redirect('/admin/view_product')->with('flash_message_success', 'Product Has Been Updated');
        }

        $productDetails = Product::where(['id' => $id])->first();
        //category categories_dropdown start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach ($categories as $cat) {
            if ($cat->id == $productDetails->category_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='" . $cat->id . "' " . $selected . ">" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                if ($sub_cat->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='" . $sub_cat->id . "' " . $selected . ">&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }
        //category categories_dropdown end
        return view('admin.products.edit_product', compact('productDetails', 'categories_dropdown'));
    }

    public function delete_product_image($id = null)
    {
        //get product image name
        $productImage = Product::where(['id' => $id])->first();
        //get product image paths
        $large_image_path = 'images/backend_image/product/large/';
        $medium_image_path = 'images/backend_image/product/medium/';
        $small_image_path = 'images/backend_image/product/small/';

        //delete large image if not exists in folder
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }
        //delete medium image if not exists in folder
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }

        //delete medium image if not exists in folder
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }
        Product::where(['id' => $id])->update(['image' => '']);
        return back()->with('flash_message_success', 'Image Deleted');
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        if (!is_null($product)) {
            //delete category image
            if (File::exists('images/backend_image/product/large/' . $product->image)) {
                File::delete('images/backend_image/product/large/' . $product->image);
            }
            if (File::exists('images/backend_image/product/medium/' . $product->image)) {
                File::delete('images/backend_image/product/medium/' . $product->image);
            }
            if (File::exists('images/backend_image/product/small/' . $product->image)) {
                File::delete('images/backend_image/product/small/' . $product->image);
            }
            $product->delete();
        }
        return back()->with('flash_message_success', 'Product Deleted');
    }

    public function add_attribute(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    //SkU check
                    $attrCountSKU = ProductsAttribute::where('sku', $val)->count();
                    if ($attrCountSKU > 0) {
                        return redirect()->back()->with('flash_message_error', 'SKU Already Exists! Please Add another SKU.');
                    }

                    $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        return redirect('admin/add_attribute/' . $id)->with('flash_message_error', '"' . $data['size'][$key] . '" Size Already Exists for this Product! Please Add another Size.');
                    }
                    //product duplicate size check
                    $attribute = new ProductsAttribute();
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();

                }
            }
            return redirect()->back()->with('flash_message_success', 'Product Attributes has been added');
        }
        return view('admin.products.add_attribute', compact('productDetails'));
    }

    public function edit_attribute(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['idAttr'] as $key => $attr) {
                ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
            return back()->with('flash_message_success', 'Product Attribute Updated');
        }
    }

    public function addImage(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $productsImage = ProductsImage::where(['product_id' => $id])->get();
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach ($files as $file) {
                    $image = new ProductsImage();
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_image/product/large/' . $filename;
                    $medium_image_path = 'images/backend_image/product/medium/' . $filename;
                    $small_image_path = 'images/backend_image/product/small/' . $filename;
                    //resize image
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            return back()->with('flash_message_success', 'Product Image Added Successfully');
        }
        return view('admin.products.add_image', compact('productDetails', 'productsImage'));
    }

    //product alternate Image Delete
    public function deleteImage($id = null)
    {
        //get product image name
        $productImage = ProductsImage::where(['id' => $id])->first();
        //get product image paths
        $large_image_path = 'images/backend_image/product/large/';
        $medium_image_path = 'images/backend_image/product/medium/';
        $small_image_path = 'images/backend_image/product/small/';

        //delete large image if not exists in folder
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }
        //delete medium image if not exists in folder
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }

        //delete medium image if not exists in folder
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }
        ProductsImage::where(['id' => $id])->delete();
        return back()->with('flash_message_success', 'Image Deleted');
    }

    public function delete_attribute($id)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Attributes has been Deleted');
    }

    public function products($url = null)
    {
        $countCategory = Category::where(['url' => $url, 'status' => 1])->count();
        if ($countCategory == 0) {
            abort(404);
        }
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['url' => $url])->first();
        if ($categoryDetails->parent_id == 0) {
            //if url is main category url
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach ($subCategories as $subcat) {
                $cat_ids[] = $subcat->id;
            }
            $productAll = Product::whereIn('category_id', $cat_ids)->where('status', 1)->get();
            $productAll = json_decode(json_encode($productAll));
        } else {
            $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status', 1)->get();
        }

        return view('product.listing', compact('categoryDetails', 'productAll', 'categories'));
    }

    public function show($id)
    {
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $category = Category::find($id);
        if (!is_null($category)) {
            return view('product.listing', compact('category', 'categories'));
        } else {
            session()->flash('errors', 'Sorry !! There is no category by this ID');
            return redirect()->back();
        }
    }

    public function product_view($id = null)
    {
        $porductCount = Product::where(['id' => $id, 'status' => 1])->count();
        if ($porductCount == 0) {
            abort(404);
        }
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $productAltImage = ProductsImage::where('product_id', $id)->get();
        //get products detail page
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $productDetails = json_decode(json_encode($productDetails));
//        echo "<pre>";print_r($productDetails);die;
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        //related Product
        $related_products = Product::where('id', '!=', $id)->where(['category_id' => $productDetails->category_id])->get();
//        $related_products=json_decode(json_encode($related_products));
//        echo "<pre>";print_r($related_products);
        return view('product.product_detail', compact('productDetails', 'categories', 'productAltImage', 'total_stock', 'related_products'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
//        echo "<pre>";print_r($data);
        $proArr = explode("-", $data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;

    }

//add to cart
    public function add_to_cart(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
//        echo "<pre>";print_r($data);die();
        if (empty($data['user_email'])) {
            $data['user_email'] = '';
        }
        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = str_random(40);
            Session::put('session_id', $session_id);
        }

        $sizeArr = explode("-", $data['size']);
        $countProducts = DB::table('carts')->where(['product_id' => $data['product_id'],
            'product_color' => $data['product_color'], 'size' => $sizeArr[1], 'session_id' => $session_id])->count();
        if ($countProducts > 0) {
            return back()->with('flash_message_error', 'This Product Already Exist in Cart!');
        } else {
            $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $sizeArr[1]])->first();

            DB::table('carts')->insert(['product_id' => $data['product_id'], 'product_name' => $data['product_name'],
                'product_code' => $getSKU->sku, 'product_color' => $data['product_color'], 'price' => $data['price'],
                'size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $session_id]);
        }

        return redirect(url('/cart'))->with('flash_message_success', 'Product has been added to Cart');
    }

    public function cart_page(Request $request)
    {
        $session_id = Session::get('session_id');
        $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
        foreach ($userCart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
//        echo "<pre>";print_r($userCart);die();
        return view('product.cart', compact('userCart'));
    }

    public function deleteCartProduct($id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('carts')->where('id', $id)->delete();
        return back()->with('flash_message_success', 'Product has been deleted from Cart!!');
    }

    public function updateCartProduct($id = null, $quantity = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getCartDetails = DB::table('carts')->where('id', $id)->first();
        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        $update_quantity = $getCartDetails->quantity + $quantity;
        if ($getAttributeStock->stock >= $update_quantity) {
            DB::table('carts')->where('id', $id)->increment('quantity', $quantity);
            return back()->with('flash_message_success', 'Product has been Updated from Cart!!');
        } else {
            return back()->with('flash_message_error', 'Required Product Quantity is not Available!!');
        }

    }

    public function applyCoupon(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if ($couponCount == 0) {
            return back()->with('flash_message_error', 'This Coupon does not exits');
        } else {
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();
            //if coupon is Inactive
            if ($couponDetails->status == 0) {
                return back()->with('flash_message_error', 'This Coupon is not Active');
            }
            //if coupon is Expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if ($expiry_date < $current_date) {
                return back()->with('flash_message_error', 'This Coupon is Expired');
            }
            //coupon is valid for discount
            //Get cart total amount
            $session_id = Session::get('session_id');
            $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
            $total_amount = 0;
            foreach ($userCart as $item) {
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }
            //check if amount type is fixed or percentage
            if ($couponDetails->amoun_type == "Fixed") {
                $couponAmount = $couponDetails->amount;
            } else {
                $couponAmount = $total_amount * ($couponDetails->amount / 100);
            }
            //add coupon code & Amount in session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['coupon_code']);
            return back()->with('flash_message_success','Coupon Code Successfully applied. You are availing discount!');
        }
    }
}
