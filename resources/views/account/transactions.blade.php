@extends('layouts.app')

@section('content')
<div class="page-header">
  <div class="add-item d-flex">
    <div class="page-title">
      <h4>Account Transactions</h4>
      <h6>View and manage transactions</h6>
    </div>
  </div>
  <ul class="table-top-head">
    <li>
        <div class="page-btn">
          <button class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#depositModal"><i data-feather="arrow-down-circle" class="me-2"></i>Deposit</button>
        </div>
    </li>
    <li>
        <div class="page-btn">
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#withdrawModal"><i data-feather="arrow-up-circle" class="me-2"></i>Withdraw</button>
        </div>
    </li>
    <li>
        <div class="page-btn">
          <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transferModal"><i data-feather="shuffle" class="me-2"></i>Transfer</button>
        </div>
    </li>
</ul>
</div>

<div class="card table-list-card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Account</th>
            <th>Type</th>
            <th>Transacted Type</th>
            <th class="text-end">Amount</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $t)
          <tr>
            <td>{{ optional($t->transacted_at)->format('d-m-Y H:i') ?? $t->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $t->account->name }}</td>
            <td class="text-capitalize">{{ str_replace('_',' ',$t->type) }}</td>
            <td class="text-capitalize">
              @if ($t->transactionable_type == 'credit')
                <span class="badge bg-success">Credit</span>
              @elseif ($t->transactionable_type == 'debate')
                <span class="badge bg-danger">Debate</span>
              @else
                <span class="badge bg-info">N/A</span>
              @endif
            </td>
            <td class="text-end">{{ number_format($t->amount,2) }}</td>
            <td>{{ $t->note }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">
              <div class="empty-state">
                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                <h5>No Transactions Found</h5>
                <p class="text-muted">Record a new deposit, withdrawal, or transfer.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#depositModal"><i class="fas fa-plus me-2"></i>Add Deposit</button>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td colspan="2" class="text-end">{{ $transactions->onEachSide(1)->links('pagination::bootstrap-5') }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('accounts.deposit') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Deposit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Account</label>
          <select name="account_id" class="form-select" required aria-label="Select account">
            <option value="">Select a account</option>
            @foreach(\App\Models\Account::forUserBusiness()->where('is_active',true)->orderBy('name')->get() as $acc)
              <option value="{{ $acc->id }}">{{ $acc->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Note</label>
          <textarea name="note" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
  </div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('accounts.withdraw') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Withdraw</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Account</label>
          <select name="account_id" class="form-select" required>
            <option value="" selected>Select a account</option>
            @foreach(\App\Models\Account::forUserBusiness()->where('is_active',true)->orderBy('name')->get() as $acc)
              <option value="{{ $acc->id }}">{{ $acc->name }} ({{ number_format($acc->current_balance,2) }})</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Note</label>
          <textarea name="note" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">Save</button>
      </div>
    </form>
  </div>
  </div>

<!-- Transfer Modal -->
<div class="modal fade" id="transferModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('accounts.transfer') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Transfer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">From Account</label>
          <select name="from_account_id" class="form-select" required>
            <option value="" selected>Select from account</option>
            @foreach(\App\Models\Account::forUserBusiness()->where('is_active',true)->orderBy('name')->get() as $acc)
              <option value="{{ $acc->id }}">{{ $acc->name }} ({{ number_format($acc->current_balance,2) }})</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">To Account</label>
          <select name="to_account_id" class="form-select" required>
            <option value="" selected>Select to account</option>
            @foreach(\App\Models\Account::forUserBusiness()->where('is_active',true)->orderBy('name')->get() as $acc)
              <option value="{{ $acc->id }}">{{ $acc->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Note</label>
          <textarea name="note" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
  </div>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
  <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

@endsection


