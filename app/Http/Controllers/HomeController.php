<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_name','asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status',1)->orderby('brand_name','asc')->get();

        $all_product = DB::table('tbl_product')->where('product_status',1)->orderby('product_id','desc')->paginate(3);
        return view('pages.home')->with('categories', $cate_product)->with('brands', $brand_product)->with('product', $all_product);
    }

    public function search(Request $request){
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_name','asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status',1)->orderby('brand_name','asc')->get();

        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->limit(6)->get();

        return view('pages.product.search')->with('categories', $cate_product)->with('brands', $brand_product)->with('search_product', $search_product);

    }
}
