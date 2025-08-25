@extends('layouts.app')

@section('content')
    <div class="page-header">
      <div class="add-item d-flex">
        <div class="page-title">
          <h4>Add Account</h4>
          <h6>Create a new account</h6>
        </div>
      </div>
      <ul class="table-top-head">
        <li>
          <div class="page-btn">
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Accounts</a>
          </div>
        </li>
      </ul>
    </div>

    <div class="card">
      <div class="card-body add-product pb-0">
        <form action="{{ route('accounts.store') }}" method="POST" class="row g-3">
          @csrf
          <div class="col-lg-4 col-sm-6 col-12">
            <div class="mb-3 add-product">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required placeholder="Enter Account Name">
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-12">
            <div class="mb-3 add-product">
              <label class="form-label">Type</label>
              <select name="type" class="select form-select" required>
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
                <option value="mobile">Mobile</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-12">
            <div class="mb-3 add-product">
              <label class="form-label">Opening Balance</label>
              <input type="number" step="0.01" name="opening_balance" class="form-control" value="0" placeholder="0.00">
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-12">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="is_default" value="1" id="is_default">
              <label class="form-check-label" for="is_default">Default account</label>
            </div>
          </div>

          <div class="col-12">
            <div class="btn-addproduct mb-4">
              <button type="button" class="btn btn-cancel me-2" onclick="window.history.back()">Cancel</button>
              <button type="submit" class="btn btn-submit">Save Account</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection


