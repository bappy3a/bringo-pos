@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4>Expense Categories</h4>
        <h6>Manage expense categories</h6>
      </div>
    </div>
    <div class="page-btn">
      <a href="{{ route('expense-categories.create') }}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add Category</a>
    </div>
  </div>

  <div class="card table-list-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Category</th>
              <th>Code</th>
              <th>Description</th>
              <th>Expenses Count</th>
              <th width="10%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
            <tr>
              <td>
                <div class="productimgname">
                  <a href="javascript:void(0);" class="product-img stock-img">
                    <img src="{{ asset('assets/img/icons/folder.svg') }}" alt="{{ $category->name }}">
                  </a>
                  <a href="javascript:void(0);">{{ $category->name }}</a>
                </div>
              </td>
              <td>{{ $category->code ?? 'N/A' }}</td>
              <td>{{ $category->description ?? 'No description' }}</td>
              <td>{{ $category->expenses_count ?? 0 }}</td>
              <td class="action-table-data">
                <div class="edit-delete-action">
                  <a class="me-2 p-2" href="{{ route('expense-categories.edit', $category->id) }}">
                    <i data-feather="edit" class="feather-edit"></i>
                  </a>
                  <a class="confirm-text p-2" href="javascript:void(0);" onclick="confirm_modal('{{ route('expense-categories.destroy', $category->id) }}')">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                  </a>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">
                <div class="empty-state">
                  <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                  <h5>No Categories Found</h5>
                  <p class="text-muted">Start by creating your first expense category.</p>
                  <a href="{{ route('expense-categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Category
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
                  @if ($categories->total() > 0)
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                  @else
                    No entries to show
                  @endif
                </div>
              </td>
              <td colspan="2" class="text-end">
                {{ $categories->onEachSide(1)->links('pagination::bootstrap-5') }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
