@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4>Add Expense</h4>
        <h6>Create a new expense</h6>
      </div>
    </div>
    <ul class="table-top-head">
      <li>
        <div class="page-btn">
          <a href="{{ route('expenses.index') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Expenses</a>
        </div>
      </li>
    </ul>
  </div>

  <div class="card">
    <div class="card-body add-product pb-0">
      <form action="{{ route('expenses.update',$expense) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('put')
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Expense Title</label>
            <input type="text" name="title" class="form-control" required placeholder="Enter expense title" value="{{ $expense->title }}">
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Category</label>
            <select name="expense_category_id" class="select form-select" required>
              <option value="">Select category</option>
              @foreach($categories as $category)
                <option @if($expense->expense_category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00" value="{{ $expense->amount }}">
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Expense Date</label>
            <input type="date" name="expense_date" class="form-control" required value="{{ $expense->expense_date }}">
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Pay From Account (Optional)</label>
            <select name="account_id" class="select form-select">
              <option value="">Select account (optional)</option>
              @foreach($accounts as $account)
                <option  @if($expense->account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }} ({{ number_format($account->current_balance,2) }})</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Reference No</label>
            <input type="text" name="reference_no" class="form-control" placeholder="Enter reference number" value="{{ $expense->reference_no }}">
          </div>
        </div>
        <div class="col-lg-12">
          <div class="mb-3 add-product">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter expense description">{{ $expense->description }}</textarea>
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Receipt</label>
            <input type="file" name="receipt" class="form-control" accept="image/*,.pdf">
            <small class="form-text text-muted">Upload receipt (JPG, PNG, PDF - Max 2MB)</small>
          </div>
        </div>
        @if ( $expense->receipt)
          <div class="col-lg-6 col-sm-6 col-12">
            <div class="mb-3 add-product">
              <div class="col-3 mt-3">
                <img src="http://bringo-pos.test/products/2025/08/qgPEKUSi3bweUJA58YUsryTcRcSe9mJgkNCV3tX3.jpg" alt="Expense report" class="img-thumbnail expense-edit-image">
              </div>
            </div>
          </div>
        @endif
        

        <div class="col-12">
          <div class="btn-addproduct mb-4">
            <button type="button" class="btn btn-cancel me-2" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="btn btn-submit">Save Expense</button>
          </div>
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
  <script>
    (function($){
      'use strict';
      $(function(){
        if ($.fn.select2) {
          $('.select').select2({ theme: 'bootstrap-5', width: '100%' });
        }
      });
    })(jQuery);
  </script>
@endsection
