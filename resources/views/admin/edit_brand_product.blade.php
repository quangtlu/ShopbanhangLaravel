@extends('admin_layout')
@section('title', 'Cập nhật thương hiệu sản phẩm')
@section('content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu sản phẩm
                </header>
                <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>$message</span>";
                    Session::put('message', null);
                }
                ?>
                <div class="panel-body">
                   @foreach($edit_brand_product as $key => $edit_value)

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea class="form-control" name="brand_product_desc" id="" cols="30" rows="10">{{$edit_value->brand_desc}}</textarea>
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
