@extends('layouts.app')

@section('title','Brands')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Brands</h4>
            <h6>Manage your categories</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addNewBrand"><i data-feather="plus-circle" class="me-2"></i>Add New Brand</a>
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
                        <th width="20%">Name</th>
                        <th class="text-center">Description</th>
                        <th width="10%" class="no-sort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brandes as $key=>$brand)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ Str::limit($brand->description,100) }}</td>
                            <td class="action-table-data text-end">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="javascript:void(0)" onclick="editBrand({{  $brand->id }})">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a onclick="confirm_modal('{{route('brands.destroy', $brand->id)}}');" class="confirm-text p-2" href="javascript:void(0);">
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

<div class="modal fade" id="addNewBrand" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crete new brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Brand name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="" placeholder="Brand description"></textarea>
                    </div>
                    <div class="modal-footer-btn">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-brand" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body" id="brand_data">
                
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
    <script>
    function editBrand(id){
        $('#brand_data').html(null);
        $.get("{{ route('brands.edit', ':id') }}".replace(':id', id), function(data){
            $('#brand_data').html(data);
            $('#edit-brand').modal('show');
        });
    }
</script>
@endsection