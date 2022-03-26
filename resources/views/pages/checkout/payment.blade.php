@extends('layout')
@section('title', 'Thanh toán')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Thanh toán</li>
                </ol>
            </div>
            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
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
            <form action="{{URL::to('/order-place')}}" method="POST">
                @csrf
            <div class="payment-options">
                <h4>Chọn hình thức thanh toán</h4>
                <span>
						<label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>
					</span>
                <span>
						<label><input name="payment_option" value="2" type="checkbox"> Thanh toán bằng tiền mặt</label>
					</span>
                <span>
						<label><input name="payment_option" value="3" type="checkbox"> Thanh toán bằng thẻ ghi nợ</label>
					</span>
                <button type="submit" class="btn btn-primary">Thanh toán</button>

            </div>

            </form>
        </div>
    </section> <!--/#cart_items-->
@endsection
