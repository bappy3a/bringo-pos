@extends('layouts.app')

@section('title','Unit')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Unit</h4>
            <h6>Manage your Units</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addNewUnit"><i data-feather="plus-circle" class="me-2"></i>Add New Unit</a>
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
                        <th width="15%">Allow decimal</th>
                        <th class="text-center">Description</th>
                        <th width="10%" class="no-sort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $key=>$unit)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->allow_decimal }}</td>
                            <td>{{ Str::limit($unit->description,100) }}</td>
                            <td class="action-table-data text-end">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="javascript:void(0)" onclick="editUnit({{  $unit->id }})">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a onclick="confirm_modal('{{route('units.destroy', $unit->id)}}');" class="confirm-text p-2" href="javascript:void(0);">
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

<div class="modal fade" id="addNewUnit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crete new unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('units.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Unit name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Allow decimal</label>
                        <select name="allow_decimal" class="select" required >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="" placeholder="Unit description"></textarea>
                    </div>
                    <div class="modal-footer-btn">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-unit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body" id="unit_data">
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-select2.js') }}"></script>
    <script>
    function editUnit(id){
        $('#unit_data').html(null);
        $.get("{{ route('units.edit', ':id') }}".replace(':id', id), function(data){
            $('#unit_data').html(data);
            $('#edit-unit').modal('show');
        });
    }
</script>
@endsection