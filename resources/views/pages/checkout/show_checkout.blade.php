@extends('layout')
@section('title', 'Thanh toán')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Thông tin thanh toán</li>
                </ol>
            </div>
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Điền thông tin gửi hàng</p>
                            <div class="form-one">
                                <form method="POST" action="{{URL::to('/save-checkout-customer')}}">
                                    @csrf
                                    <input type="text" name="shipping_name" placeholder="Họ và tên">
                                    <input type="tel" name="shipping_phone" placeholder="Số điện thoại">
                                    <input type="email" name="shipping_email" placeholder="Email">
                                    <input type="text" name="shipping_address" placeholder="Địa chỉ">
                                    <textarea name="shipping_note"  placeholder="Ghi chú đơn hàng của bạn" rows="16" ></textarea>
                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--/#cart_items-->
@endsection
