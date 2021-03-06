@extends('layout')
@section('title', 'Giỏ hàng')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Giỏ hàng</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $content = Cart::content();?>
                    @foreach($content as $value)
                    <tr>
                        <td class="cart_product">
                            <a href="">
                                <img height="100px" width="100px" src="{{URL::to('public/uploads/product/'.$value->options->image)}}" alt="" />
                            </a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$value->name}}</a></h4>
                            <p>ID Sản phẩm: {{$value->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($value->price)}}đ</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    @csrf
                                    <input class="cart_quantity_input" type="text" name="quantity" value="{{$value->qty}}" autocomplete="off" size="2">
                                    <input type="text" value="{{$value->rowId}}" name="rowId_cart" hidden>
                                    <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-sm btn-default">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"><?php $subtotal = $value->price * $value->qty; echo number_format($subtotal) ?> đ</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$value->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container">
{{--            <div class="heading">--}}
{{--                <h3>What would you like to do next?</h3>--}}
{{--                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>--}}
{{--            </div>--}}
            <div class="row">
{{--                <div class="col-sm-6">--}}
{{--                    <div class="chose_area">--}}
{{--                        <ul class="user_option">--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Use Coupon Code</label>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Use Gift Voucher</label>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Estimate Shipping & Taxes</label>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <ul class="user_info">--}}
{{--                            <li class="single_field">--}}
{{--                                <label>Country:</label>--}}
{{--                                <select>--}}
{{--                                    <option>United States</option>--}}
{{--                                    <option>Bangladesh</option>--}}
{{--                                    <option>UK</option>--}}
{{--                                    <option>India</option>--}}
{{--                                    <option>Pakistan</option>--}}
{{--                                    <option>Ucrane</option>--}}
{{--                                    <option>Canada</option>--}}
{{--                                    <option>Dubai</option>--}}
{{--                                </select>--}}

{{--                            </li>--}}
{{--                            <li class="single_field">--}}
{{--                                <label>Region / State:</label>--}}
{{--                                <select>--}}
{{--                                    <option>Select</option>--}}
{{--                                    <option>Dhaka</option>--}}
{{--                                    <option>London</option>--}}
{{--                                    <option>Dillih</option>--}}
{{--                                    <option>Lahore</option>--}}
{{--                                    <option>Alaska</option>--}}
{{--                                    <option>Canada</option>--}}
{{--                                    <option>Dubai</option>--}}
{{--                                </select>--}}

{{--                            </li>--}}
{{--                            <li class="single_field zip-field">--}}
{{--                                <label>Zip Code:</label>--}}
{{--                                <input type="text">--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <a class="btn btn-default update" href="">Get Quotes</a>--}}
{{--                        <a class="btn btn-default check_out" href="">Continue</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Tổng<span>{{Cart::priceTotal(0)}} đ</span></li>
                            <li>Thuế<span>{{Cart::tax(0)}} đ</span></li>
                            <li>Phí vận chuyển<span>Free</span></li>
                            <li>Thành tiền <span>{{Cart::total(0)}} đ</span></li>
                        </ul>
{{--                        <a class="btn btn-default update" href="">Update</a>--}}
                        <?php
                        $customer_id = Session::get('customer_id');
                        $shipping_id = Session::get('shipping_id');

                        if($customer_id != NULL && $shipping_id == NULL){
                        ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a>
                        <?php
                        }
                        elseif($customer_id != NULL && $shipping_id != NULL){ ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/payment')}}"><i class="fa fa-lock"></i> Thanh toán</a>
                        <?php }else{ ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->

@endsection
