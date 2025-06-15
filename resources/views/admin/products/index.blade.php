@extends('admin.layout') 

@section('content')
<div class="container">
    <h2>Product List</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">Add Product</a>

    <table class="table">
        <thead>
            <tr><th>Name</th><th>SKU</th><th>Price</th><th>Qty</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this product?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
