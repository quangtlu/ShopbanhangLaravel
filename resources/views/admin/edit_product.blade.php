@extends('admin_layout')
@section('title', 'Cập nhật sản phẩm')
@section('content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
                </header>
                <div class="panel-body">
                    <?php
					$message = Session::get('message');
					if($message){
						echo "<span class='text-alert'>$message</span>";
						Session::put('message', null);
					}
				    ?>
                    <div class="position-center">
                        @foreach($edit_product as $key => $pro)
                        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input value="{{$pro->product_name}}" type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input value="{{$pro->product_price}}" type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" alt="{{$pro->product_image}}" class="product_img">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea class="form-control" value="{{$pro->product_desc}}" name="product_desc" id="" cols="30" rows="10">{{$pro->product_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea class="form-control" value="{{$pro->product_content}}" name="product_content" id="" cols="30" rows="10">{{$pro->product_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_cate">Danh mục sản phẩm</label>
                            <select id="product_cate" name="category_id" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    @if($cate->category_id == $pro->category_id)
                                        <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @else
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_brand">Thương hiệu sản phẩm</label>
                            <select id="product_brand" name="brand_id" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    @if($brand->brand_id == $pro->brand_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option  value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_status">Hiển thị</label>
                            <select id="product_status" name="product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiện</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Cập nhật</button>
                    </form>
                    </div>
                        @endforeach
                </div>
            </section>

    </div>
</div>
@endsection
