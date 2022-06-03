@extends('layouts.app')
@section('add_product')
<div class="container w-50">
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="text-primary text-center">Add Product Form</h1>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-2">
                <label for="name_product">Name Product</label>
                <input type="text" class="form-control" name= "name_product" placeholder="Enter the name...">
            </div>
            <div class="form-group mt-2">
                <label for="price_product">Price Product</label>
                <input type="text" class="form-control" name="price_product" placeholder="Enter the price...">
            </div>
            <div class="form-group mt-2">
                <label for="image_product" class="form-label">Upload Image</label>
                <input class="form-control form-control-sm" name="image_product" type="file">
            </div>
            <div class="form-group mt-2">
                <label for="des_product">Decription</label>
                <textarea class="form-control" name="des_product" rows="3"></textarea>
            </div>
            <div class="form-group mt-2 d-flex flex-row align-items-center justify-content-between">
                <button type="submit" class="btn btn-primary mb-3">Add Product</button>
                <a href="{{route('product.index')}}" class="nav-link border border-secondary  bg-secondary text-white rounded">Back</a>
            </div>
        </form>
    </div>

</div>
@endsection
