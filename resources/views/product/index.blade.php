@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Product List</h4>
            <h6>Manage your products</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="{{ route('products.create') }}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add New Product</a>
    </div>	
</div>

<!-- /product list -->
<div class="card table-list-card">
    <div class="card-body">
        <div class="table-top">
            <form action="{{ route('products.index') }}" method="GET" class="w-100">
                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <input type="text" name="s" value="{{ request('s') }}" class="form-control" placeholder="Search by name or SKU">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="category_id" class="select">
                            <option value="">All Categories</option>
                            @isset($categories)
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="brand_id" class="form-select select">
                            <option value="">All Brands</option>
                            @isset($brands)
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary"> Search</button>
                        @if(request()->hasAny(['s','category_id','brand_id']))
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive product-list">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Qty</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key=>$product)
                        <tr>
                            <td>
                                <div class="productimgname">
                                    <a href="javascript:void(0);" class="product-img stock-img">
                                        <img src="{{ asset($product->images) ?? asset('asset/images/image-not-found.avif') }} " alt="{{ $product->name }}">
                                    </a>
                                    <a href="javascript:void(0);">{{ $product->name }} </a>
                                </div>												
                            </td>
                            <td>{{ number_format($product->latest_purchase_price ?? 0, 2) }}</td>
                            <td>{{ number_format($product->latest_selling_price ?? 0, 2) }}</td>
                            <td>{{ number_format($product->total_unsell ?? 0,1) }} {{$product->unit->name}}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="me-2 edit-icon  p-2" href="{{ route('products.show',$product->slug) }}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="me-2 p-2" href="{{ route('products.edit',$product->id) }}" >
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a onclick="confirm_modal('{{route('products.destroy', $product->id)}}');" class="confirm-text p-2" href="javascript:void(0);">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="align-middle">
                            <div class="text-muted small mb-0">
                                @if ($products->total() > 0)
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                                @else
                                    No entries to show
                                @endif
                            </div>
                        </td>
                        <td colspan="4" class="text-end">
                            {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection