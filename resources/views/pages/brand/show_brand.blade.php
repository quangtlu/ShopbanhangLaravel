@extends('layout')
@section('title', 'Sản phẩm theo thương hiệu')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">{{$brand->brand_name}}</h2>
        @foreach($product as $key => $pro)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" alt="" />
                            <h2>{{number_format($pro->product_price)}}₫</h2>
                            <p>{{$pro->product_name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                        </div>
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <h2>{{number_format($pro->product_price)}}₫</h2>
                                <p>{{$pro->product_name}}</p>
                                <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i>Xem chi tiết</a>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                            </div>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{$product->links()}}


@endsection
