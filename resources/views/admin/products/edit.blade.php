@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PUT')

        <input 
            name="name" 
            class="form-control mb-2" 
            placeholder="Name" 
            value="{{ old('name', $product->name) }}"
        >
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <input 
            name="sku" 
            class="form-control mb-2" 
            placeholder="SKU" 
            value="{{ old('sku', $product->sku) }}"
        >
        @error('sku')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <input 
            name="price" 
            type="number" 
            step="0.01" 
            class="form-control mb-2" 
            placeholder="Price" 
            value="{{ old('price', $product->price) }}"
        >
        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <input 
            name="quantity" 
            type="number" 
            class="form-control mb-2" 
            placeholder="Quantity" 
            value="{{ old('quantity', $product->quantity) }}"
        >
        @error('quantity')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <button class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
