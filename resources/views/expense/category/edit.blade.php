@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4>Edit Expense Category</h4>
        <h6>Update category information</h6>
      </div>
    </div>
    <ul class="table-top-head">
      <li>
        <div class="page-btn">
          <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Categories</a>
        </div>
      </li>
    </ul>
  </div>

  <div class="card">
    <div class="card-body add-product pb-0">
      <form action="{{ route('expense-categories.update', $expenseCategory->id) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $expenseCategory->name }}" required placeholder="Enter category name">
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="mb-3 add-product">
            <label class="form-label">Category Code</label>
            <input type="text" name="code" class="form-control" value="{{ $expenseCategory->code }}" placeholder="Enter category code (optional)">
          </div>
        </div>
        <div class="col-lg-12">
          <div class="mb-3 add-product">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter category description">{{ $expenseCategory->description }}</textarea>
          </div>
        </div>

        <div class="col-12">
          <div class="btn-addproduct mb-4">
            <button type="button" class="btn btn-cancel me-2" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="btn btn-submit">Update Category</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
