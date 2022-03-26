<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');

        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();

        }
    }
    public function all_product(){
        $this->AuthLogin();

        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
            ->join('tbl_brand_product','tbl_product.brand_id','=','tbl_brand_product.brand_id')
            ->orderby('tbl_product.product_id','desc')->paginate(4);
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function add_product(){
        $this->AuthLogin();

        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();

        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }

    public function save_product(Request $request){
        $this->AuthLogin();

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
        }
        else{
            $data['product_image'] = '';
        }
        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm mới sản phẩm thành công !');
        return Redirect::to('all-product');



    }

    public function active_product($product_id){
        $this->AuthLogin();

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Sản phẩm đã được hiển thị !');
        return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
        $this->AuthLogin();

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Sản phẩm đã được ẩn !');
        return Redirect::to('all-product');

    }

    public function edit_product($product_id){
        $this->AuthLogin();

        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)
            ->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }

    public function update_product(Request $request,$product_id){
        $this->AuthLogin();

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;
        $data['category_id'] = $request->category_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công !');
        return Redirect::to('all-product');

    }

    public function delete_product($product_id){
        $this->AuthLogin();

        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công !');
        return Redirect::to('all-product');
    }

    public function show_detail_product($product_id){
        $product = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('product_id',$product_id)->first();
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_name','asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status',1)->orderby('brand_name','asc')->get();

        $category_id = $product->category_id;
        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.product.product_detail')->with('product',$product)->with('categories', $cate_product)->with('brands', $brand_product)->with('related_product', $related_product);
    }
}
