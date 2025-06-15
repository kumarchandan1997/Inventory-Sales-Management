@extends('admin.layout') 

@section('content')
<div class="container">
    <h2>Create Product</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops! Something went wrong.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <input name="name" value="{{ old('name') }}" class="form-control mb-2" placeholder="Name">
        <input name="sku" value="{{ old('sku') }}" class="form-control mb-2" placeholder="SKU">
        <input name="price" type="number" step="0.01" value="{{ old('price') }}" class="form-control mb-2" placeholder="Price">
        <input name="quantity" type="number" value="{{ old('quantity') }}" class="form-control mb-2" placeholder="Quantity">
        
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
