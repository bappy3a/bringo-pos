@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Purchase Details</h4>
                <h6>View purchase information</h6>
            </div>
            <div class="add-item-btn">
                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Purchase
                </a>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Reference No:</strong></td>
                                    <td>{{ $purchase->reference_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td>{{ $purchase->contact->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Purchase Date:</strong></td>
                                    <td>{{ $purchase->date ? Carbon\Carbon::parse($purchase->date)->format('d M Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created By:</strong></td>
                                    <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td><span class="badge bg-success fs-6">{{ number_format($purchase->total, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        @if($purchase->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($purchase->payment_status == 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created At:</strong></td>
                                    <td>{{ $purchase->created_at ? $purchase->created_at->format('d M Y H:i') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $purchase->updated_at ? $purchase->updated_at->format('d M Y H:i') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($purchase->note)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Notes:</h6>
                                <p class="text-muted">{{ $purchase->note }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Summary</h5>
                </div>
                <div class="card-body">
                    <div class="summary-item">
                        <span class="label">Subtotal:</span>
                        <span class="value">{{ number_format($purchase->amount, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Discount:</span>
                        <span class="value text-danger">-{{ number_format($purchase->discount, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Tax:</span>
                        <span class="value text-info">+{{ number_format($purchase->tax, 2) }}</span>
                    </div>
                    <hr>
                    <div class="summary-item total">
                        <span class="label">Total:</span>
                        <span class="value">{{ number_format($purchase->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">Purchase Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Purchase Price</th>
                            <th class="text-end">Selling Price</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseDetails as $detail)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{asset($detail->product->images) }}" 
                                             alt="{{ $detail->product->names }}" 
                                             class="product-image me-3"
                                             onerror="this.src='{{ asset('assets/images/image-not-found.avif') }}'">
                                        <div>
                                            <strong>{{ $detail->product->name }}</strong>
                                            @if($detail->product->category)
                                                <br><small class="text-muted">{{ $detail->product->category->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $detail->product->sku ?? 'N/A' }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-end">{{ number_format($detail->purchase_price, 2) }}</td>
                                <td class="text-end">{{ number_format($detail->selling_price, 2) }}</td>
                                <td class="text-end">{{ number_format($detail->discount ?? 0, 2) }}</td>
                                <td class="text-end">{{ number_format($detail->tax ?? 0, 2) }}</td>
                                <td class="text-end"><strong>{{ number_format($detail->total, 2) }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-box fa-2x text-muted mb-2"></i>
                                        <p class="text-muted">No items found in this purchase.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-item.total {
            font-weight: bold;
            font-size: 1.1em;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .product-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .empty-state {
            padding: 20px;
            text-align: center;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .badge {
            font-size: 0.875em;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .add-item {
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection
