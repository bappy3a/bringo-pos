@extends('layouts.app')

@section('content')

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Purchase Returns</h4>
            <h6>Manage your returned purchases</h6>
        </div>
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
                        <th>Returned Qty</th>
                        <th>Created By</th>
                        <th width="10%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td><strong>{{ $purchase->reference_no ?? 'N/A' }}</strong></td>
                            <td>{{ $purchase->contact->name ?? 'N/A' }}</td>
                            <td>{{ $purchase->date ? Carbon\Carbon::parse($purchase->date)->format('d M Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-success">{{ number_format($purchase->total, 2) }}</span>
                            </td>
                            <td>
                                {{ $purchase->purchaseDetails->sum('quantity_returned') ?? 0 }}
                            </td>
                            <td>
                                @if ($purchase->user)
                                    {{ $purchase->user->first_name.' '.$purchase->user->last_name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="action-table-data text-end">
                                <div class="edit-delete-action">
                                    <a class="me-2 edit-icon  p-2" href="{{ route('purchases.show', $purchase->id) }}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="me-2 p-2" href="{{ route('purchase.return', $purchase->id) }}" >
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a onclick="confirm_modal('{{route('purchase.return.clear', $purchase->id)}}');" class="confirm-text p-2" href="javascript:void(0);">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-undo fa-3x text-muted mb-3"></i>
                                    <h5>No Purchase Returns Found</h5>
                                    <p class="text-muted">Returns will appear here when processed.</p>
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
                        <td colspan="3" class="text-end">
                            {{ $purchases->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .empty-state { padding: 40px 20px; text-align: center; }
    .table th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; }
    .badge { font-size: 0.75em; }
    .page-header { margin-bottom: 30px; }
    .card { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); border: 1px solid rgba(0,0,0,.125); }
</style>
@endsection
