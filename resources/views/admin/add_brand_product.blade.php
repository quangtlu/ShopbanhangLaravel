@extends('admin_layout')
@section('title', 'Thêm thương hiệu sản phẩm')
@section('content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu sản phẩm
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
                        <form role="form" action="{{URL::to('/save-brand-product')}}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea class="form-control" name="brand_product_desc" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand_product_status">Hiển thị</label>
                            <select id="brand_product_status" name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiện</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Thêm mới</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
</div>
@endsection
