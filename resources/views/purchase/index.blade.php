@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Purchases</h4>
                <h6>Manage your purchases</h6>
            </div>
            <div class="add-item-btn">
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Purchase
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Reference No</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Created By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>
                                    <strong>{{ $purchase->reference_no ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    {{ $purchase->contact->name ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $purchase->date ? Carbon\Carbon::parse( $purchase->date)->format('d M Y') : 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ number_format($purchase->total, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($purchase->payment_status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($purchase->payment_status == 'partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $purchase->user->name ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('purchases.show', $purchase->id) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('purchases.edit', $purchase->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Delete"
                                                onclick="deletePurchase({{ $purchase->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h5>No Purchases Found</h5>
                                        <p class="text-muted">Start by creating your first purchase.</p>
                                        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Purchase
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($purchases->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        function deletePurchase(purchaseId) {
            Swal.fire({
                title: 'Delete Purchase',
                text: 'Are you sure you want to delete this purchase? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form to submit the delete request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/purchases/${purchaseId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Show success/error messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection

@section('css')
    <style>
        .empty-state {
            padding: 40px 20px;
            text-align: center;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .badge {
            font-size: 0.75em;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .add-item {
            justify-content: space-between;
            align-items: center;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
@endsection