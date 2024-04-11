@extends('categories.layout')

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 margin-tb">
            <div style="text-align: center;">
                <h4>How To Create Laravel 10 CRUD Application with Bootstrap</h4>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('categories.create') }}">
                    Add New Category
                </a>
                <a class="btn btn-info" href="{{ route('products.index') }}">
                    Products List
                </a>
            </div>
        </div>
    </div>

    <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered" style="margin-top: 20px;">
        <tr>
            <th>Name</th>
            <th>List Product</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>
                    @foreach($category->products as $product)
                        <li>
                            {{$product->name}}
                        </li>
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

        @endforeach
    </table>

@endsection
