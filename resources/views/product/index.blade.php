@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="row mt-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>Products</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('product.create') }}">Add Products</a>
                        @if(auth()->user()->role == 'admin')
                        <a class="btn btn-secondary" href="{{ route('admin') }}">Back</a>
                        @elseif(auth()->user()->role == 'user')
                        <a class="btn btn-secondary" href="{{ route('user') }}">Back</a>
                        @endif
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <th>{{ $product->price }}</th>
                    <td><img src="/image/{{ $product->image }}" width="100px"></td>
                    <td>
                        <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                            
                            <a class="btn btn-warning" href="{{ route('product.edit',$product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button> 
                        </form>
                    </td> 
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection