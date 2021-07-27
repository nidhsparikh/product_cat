@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="row mt-4">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>Category</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('category.create') }}">Add Category</a>
                        <a class="btn btn-secondary" href="{{ route('admin') }}">Back</a>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Category Name</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($category as $cat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>
                        <form action="{{ route('category.destroy',$cat->id) }}" method="POST">
                            
                            <a class="btn btn-warning" href="{{ route('category.edit',$cat->id) }}">Edit</a>
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