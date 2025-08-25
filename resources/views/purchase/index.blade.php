@extends('layouts.app')

@section('content')

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Purchases List</h4>
            <h6>Manage your purchases</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="{{ route('purchases.create') }}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add New Purchase</a>
    </div>	
</div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table table-hover">
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
                                    @if($purchase->payment_status == 'pay')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($purchase->payment_status == 'partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($purchase->user)
                                        {{ $purchase->user->first_name.' '.$purchase->user->last_name }}
                                    @else
                                        N/A
                                    @endif
                                    
                                </td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="dropdown-item"><i data-feather="eye" class="info-img"></i>Purchase Detail</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="dropdown-item" ><i data-feather="edit" class="info-img"></i>Edit Purchase</a>
                                        </li>	
                                        <li>
                                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="dropdown-item" ><i data-feather="refresh-ccw" class="info-img"></i>Purchase Return</a>
                                        </li>	
                                        <li>
                                            <a onclick="confirm_modal('{{route('purchases.destroy', $purchase->id)}}');" href="javascript:void(0);" class="dropdown-item"><i data-feather="trash-2" class="info-img"></i>Delete Sale</a>
                                        </li>								
                                    </ul>
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
                    <tfoot>
                        <tr>
                            <td colspan="4" class="align-middle">
                                <div class="text-muted small mb-0">
                                    @if ($purchases->total() > 0)
                                        Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} entries
                                    @else
                                        No entries to show
                                    @endif
                                </div>
                            </td>
                            <td colspan="4" class="text-end">
                                {{ $purchases->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
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