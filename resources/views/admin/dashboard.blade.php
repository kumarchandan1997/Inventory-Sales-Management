@extends('admin.layout') 

@section('content')
<div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text">₹{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Low Stock Alerts</h5>
                        <p class="card-text">{{ $lowStockProducts->count() }} product(s)</p>
                    </div>
                </div>
            </div>
        </div>

        @if($lowStockProducts->count())
            <div class="card">
                <div class="card-header bg-warning">
                    <strong>Low Stock Products</strong>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($lowStockProducts as $product)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $product->name }} (SKU: {{ $product->sku }})
                            <span class="badge bg-danger">{{ $product->quantity }} left</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

   




</div>
@endsection

