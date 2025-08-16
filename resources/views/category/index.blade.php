@extends('layouts.app')

@section('title','Category')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Category</h4>
            <h6>Manage your categories</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addNewCategory"><i data-feather="plus-circle" class="me-2"></i>Add New Category</a>
    </div>
</div>
<!-- /product list -->
<div class="card table-list-card">
    <div class="card-body">
        <div class="table-top">
            <div class="search-set">
                <div class="search-input">
                    <a href="" class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                </div>
            </div>
        </div>
        <!-- /Filter -->
        <div class="table-responsive">
            <table class="table datanew">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="15%">Image</th>
                        <th width="20%">Name</th>
                        <th width="15%">Code</th>
                        <th class="text-center">Description</th>
                        <th width="10%" class="no-sort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorys as $key=>$category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><img src="{{ asset($category->image) }}" width="40" alt=""></td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->code }}</td>
                            <td>{{ Str::limit($category->description,100) }}</td>
                            <td class="action-table-data text-end">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-category">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="confirm-text p-2" href="javascript:void(0);">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crete new category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input name="code" type="text" class="form-control" placeholder="Category code">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input name="image" class="form-control" type="file" id="formFile">
                        <span class="form-text text-muted">Size 40 * 40 px</span>
                       
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="" placeholder="Category description"></textarea>
                    </div>
                    <div class="modal-footer-btn">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crete new category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input name="code" type="text" class="form-control" placeholder="Category code">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input name="image" class="form-control" type="file" id="formFile">
                        <span class="form-text text-muted">Size 40 * 40 px</span>
                       
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="" placeholder="Category description"></textarea>
                    </div>
                    <div class="modal-footer-btn">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection