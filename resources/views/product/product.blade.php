@extends('layouts.app')
@section('content_product')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="text-center">
        <h1 class="text-danger mb-5">Table Product</h1>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div class="p2">
            <a name="" id="" class="btn btn-primary" href="{{route('product.create')}}" role="button">Add Product</a>
        </div>
        <div class="form-inline p2 d-flex justify-content-between">
            <input class="form-control mr-sm-2 me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </div>
    </div>

    <table class="table table-responsive text-center">
        <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Description</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td scope="row">{{$product->name}}</td>
                    <td class="w-25">
                        <img class= "img-thumbnail rounded w-50" src="{{ asset('uploads/' . $product->image_link) }}" alt="">
                    </td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->created_at->format('d/m/Y')}}</td>
                    <td>{{$product->updated_at->format('d/m/Y')}}</td>
                    <td>
                        <div class="d-flex flex-row align-items-center justify-content-around">
                            <a href="" class="nav-link border border-danger w-25 bg-danger text-white rounded">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="{{route('product.edit',$product->id)}}" class="nav-link border border-warning w-25 bg-warning text-white rounded">
                                <i class="fa-solid fa-marker"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
