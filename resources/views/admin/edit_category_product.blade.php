@extends('admin_layout')
@section('title', 'Cập nhật danh mục sản phẩm')
@section('content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
                </header>
                <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-alert'>$message</span>";
                    Session::put('message', null);
                }
                ?>
                <div class="panel-body">
                   @foreach($edit_category_product as $key => $edit_value)

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea class="form-control" name="category_product_desc" id="" cols="30" rows="10">{{$edit_value->category_desc}}</textarea>
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
