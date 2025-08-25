@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4>Expenses</h4>
        <h6>Manage your expenses</h6>
      </div>
    </div>
    <div class="page-btn">
      <a href="{{ route('expenses.create') }}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add Expense</a>
    </div>
  </div>

  <div class="card table-list-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Expense</th>
              <th>Category</th>
              <th>Account</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Added By</th>
              <th width="10%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($expenses as $expense)
            <tr>
              <td>
                <div class="productimgname">
                  <a href="javascript:void(0);" class="product-img stock-img">
                    <img src="{{ asset('assets/img/icons/expense.svg') }}" alt="{{ $expense->title }}">
                  </a>
                  <a href="javascript:void(0);">{{ $expense->title }}</a>
                  @if($expense->reference_no)
                    <br><small class="text-muted">Ref: {{ $expense->reference_no }}</small>
                  @endif
                </div>
              </td>
              <td>{{ $expense->category->name }}</td>
              <td>{{ $expense->account ? $expense->account->name : 'N/A' }}</td>
              <td><strong class="text-danger">{{ number_format($expense->amount, 2) }}</strong></td>
              <td>{{ Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') }}</td>
              <td>{{ $expense->user->first_name }} {{ $expense->user->last_name }}</td>
              <td class="action-table-data">
                <div class="edit-delete-action">
                  <a class="me-2 edit-icon p-2" href="{{ route('expenses.show', $expense->id) }}">
                    <i data-feather="eye" class="feather-eye"></i>
                  </a>
                  <a class="me-2 p-2" href="{{ route('expenses.edit', $expense->id) }}">
                    <i data-feather="edit" class="feather-edit"></i>
                  </a>
                  <a class="confirm-text p-2" href="javascript:void(0);" onclick="confirm_modal('{{ route('expenses.destroy', $expense->id) }}')">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                  </a>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">
                <div class="empty-state">
                  <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                  <h5>No Expenses Found</h5>
                  <p class="text-muted">Start by creating your first expense.</p>
                  <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Expense
                  </a>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="align-middle">
                <div class="text-muted small mb-0">
                  @if ($expenses->total() > 0)
                    Showing {{ $expenses->firstItem() }} to {{ $expenses->lastItem() }} of {{ $expenses->total() }} entries
                  @else
                    No entries to show
                  @endif
                </div>
              </td>
              <td colspan="4" class="text-end">
                {{ $expenses->onEachSide(1)->links('pagination::bootstrap-5') }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
