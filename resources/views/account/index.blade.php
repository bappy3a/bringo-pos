@extends('layouts.app')

@section('content')
<div class="page-header">
  <div class="add-item d-flex">
    <div class="page-title">
      <h4>Accounts</h4>
      <h6>Manage your accounts</h6>
    </div>
  </div>
  <div class="page-btn">
    <a href="{{ route('accounts.create') }}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add Account</a>
  </div>
</div>

<div class="card table-list-card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Account</th>
            <th>Type</th>
            <th>Opening</th>
            <th>Balance</th>
            <th>Status</th>
            <th>Default</th>
            <th width="10%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($accounts as $account)
          <tr>
            <td>
              <div class="productimgname">
                <a href="javascript:void(0);" class="product-img stock-img">
                  <img src="{{ asset('assets/img/icons/wallet.svg') }}" alt="{{ $account->name }}">
                </a>
                <a href="javascript:void(0);">{{ $account->name }}</a>
              </div>
            </td>
            <td class="text-capitalize">{{ $account->type }}</td>
            <td>{{ number_format($account->opening_balance,2) }}</td>
            <td><strong>{{ number_format($account->current_balance,2) }}</strong></td>
            <td>
              <span class="badge bg-{{ $account->is_active ? 'success' : 'secondary' }}">{{ $account->is_active ? 'Active' : 'Inactive' }}</span>
            </td>
            <td>
              @if($account->is_default)
                <span class="badge bg-info">Default</span>
              @endif
            </td>
            <td class="action-table-data">
              <div class="edit-delete-action">
                <a class="me-2 p-2" href="{{ route('accounts.edit',$account->id) }}"><i data-feather="edit" class="feather-edit"></i></a>
                <a class="confirm-text p-2" href="javascript:void(0);" onclick="confirm_modal('{{ route('accounts.destroy',$account->id) }}')"><i data-feather="trash-2" class="feather-trash-2"></i></a>
                <form id="delete-form-{{ $account->id }}" action="{{ route('accounts.destroy',$account->id) }}" method="POST" class="d-none">
                  @csrf
                  @method('DELETE')
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center">
              <div class="empty-state">
                <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                <h5>No Accounts Found</h5>
                <p class="text-muted">Start by creating your first account.</p>
                <a href="{{ route('accounts.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create Account</a>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" class="align-middle">
              <div class="text-muted small mb-0">
                @if ($accounts->total() > 0)
                  Showing {{ $accounts->firstItem() }} to {{ $accounts->lastItem() }} of {{ $accounts->total() }} entries
                @else
                  No entries to show
                @endif
              </div>
            </td>
            <td colspan="3" class="text-end">
              {{ $accounts->onEachSide(1)->links('pagination::bootstrap-5') }}
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection


