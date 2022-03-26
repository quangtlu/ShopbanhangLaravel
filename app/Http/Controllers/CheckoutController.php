<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
class CheckoutController extends Controller
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

    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_name', 'asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_name', 'asc')->get();
        return view('pages.checkout.login_checkout')->with('categories', $cate_product)->with('brands', $brand_product);
    }

    public function add_customer(Request $request){
        $data = [];
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return Redirect::to('/checkout');
    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_name', 'asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_name', 'asc')->get();
        return view('pages.checkout.show_checkout')->with('categories', $cate_product)->with('brands', $brand_product);
    }

    public function save_checkout_customer(Request $request){
        $data = [];
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function login_customer(Request $request){
        $email_account = $request->email_account;
        $password_account = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email_account)->where('customer_password', $password_account)->first();

        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        }
        else{
            return Redirect::to('/login-checkout');
        }


    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_name', 'asc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_name', 'asc')->get();
        return view('pages.checkout.payment')->with('categories', $cate_product)->with('brands', $brand_product);
    }

    public function order_place(Request $request){
//        insert payment method
        $data = [];
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';

        $payment_id = DB::table('tbl_payment')->insertGetId($data);

//        insert order
        $order_data = [];
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total(0);
        $order_data['order_status'] = 'Đang chờ xử lý';

        $order_id = DB::table('tbl_order')->insertGetId($order_data);

//        insert order details

        $content = Cart::content();
        $orderD_data = [];

        foreach($content as $value){
            $orderD_data['order_id'] = $order_id;
            $orderD_data['product_id'] = $value->id;
            $orderD_data['product_name'] = $value->name;
            $orderD_data['product_price'] = $value->price;
            $orderD_data['product_sales_quantity'] = $value->qty;

            DB::table('tbl_order_details')->insert($orderD_data);
        }

        if($data['payment_method'] == 1){
            echo 'Thanh toán bằng thẻ ATM';
        }
        elseif($data['payment_method'] == 2){
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_name', 'asc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status', 1)->orderby('brand_name', 'asc')->get();
            return view('pages.checkout.handcash')->with('categories', $cate_product)->with('brands', $brand_product);
        }
        else{
            echo 'Thẻ ghi nợ';
        }


    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
            ->select('tbl_order.*','tbl_customer.customer_name')
            ->orderby('order_id','desc')->paginate(4);
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }

    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')->where('tbl_order.order_id', $order_id)
            ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
            ->join('tbl_shipping','tbl_shipping.shipping_id','=','tbl_order.shipping_id')
            ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
            ->select('tbl_order_details.*','tbl_customer.*','tbl_shipping.*')->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);

    }

}
