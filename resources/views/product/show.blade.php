@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Product Details</h4>
            <h6>View product information</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <div class="page-btn">
                <a href="{{ route('products.index') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Product</a>
            </div>
        </li>
        <li>
            <div class="page-btn">
                <a href="{{ route('products.edit',$item->id) }}" class="btn btn-secondary"><i data-feather="edit" class="me-2"></i>Edit Product</a>
            </div>
        </li>
    </ul>
    
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ $item->images ? asset($item->images) : asset('assets/images/image-not-found.avif') }}" alt="{{ $item->name }}" class="img-fluid rounded" style="max-height:220px; object-fit:contain;">
                </div>
                <h5 class="mb-1">{{ $item->name }}</h5>
                <p class="text-muted mb-3">SKU: {{ $item->sku ?? 'N/A' }}</p>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th class="w-50">Category</th>
                                <td>{{ optional($item->category)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td>{{ optional($item->brand)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ optional($item->unit)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Barcode Type</th>
                                <td>{{ strtoupper(str_replace('_',' ',$item->barcode_type ?? 'N/A')) }}</td>
                            </tr>
                            <tr>
                                <th>Alert Quantity</th>
                                <td>{{ $item->alert_quantity ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if(($item->status ?? 'active') === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Not for Selling</th>
                                <td>
                                    @if((int)($item->not_for_selling ?? 0) === 1)
                                        <span class="badge bg-warning text-dark">Yes</span>
                                    @else
                                        <span class="badge bg-light text-dark">No</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Stock & Pricing</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 border rounded h-100">
                            <div class="text-muted small">Total Stock</div>
                            <div class="fs-5 fw-semibold">{{ number_format($item->total_stock ?? 0, 2) }} {{ optional($item->unit)->name }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 border rounded h-100">
                            <div class="text-muted small">Latest Purchase Price</div>
                            <div class="fs-5 fw-semibold">{{ number_format($item->latest_purchase_price ?? 0, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 border rounded h-100">
                            <div class="text-muted small">Latest Selling Price</div>
                            <div class="fs-5 fw-semibold">{{ number_format($item->latest_selling_price ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Description</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $item->description ?: 'No description provided.' }}</p>
            </div>
        </div>
    </div>
</div>

@endsection