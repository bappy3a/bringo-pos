@extends('layouts.app')

@section('title','Customers')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Customers</h4>
            <h6>Manage your Customers</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addNewContacts"><i data-feather="plus-circle" class="me-2"></i>Add New Customers</a>
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
                        <th width="7%">No</th>
                        <th width="20%">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th width="10%" class="no-sort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $key=>$contact)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->address }}</td>
                            <td class="action-table-data text-end">
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2" href="javascript:void(0)" onclick="editContacts({{  $contact->id }})">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a onclick="confirm_modal('{{route('contacts.destroy', $contact->id)}}');" class="confirm-text p-2" href="javascript:void(0);">
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

@include('contact.create')
@php
    $type = request()->query('type');
@endphp
<div class="modal fade" id="edit-customers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if($type == 'customer')
                    <h5 class="modal-title" id="staticBackdropLabel">Update customer</h5>
                @elseif($type == 'supplier')
                    <h5 class="modal-title" id="staticBackdropLabel">Update supplier</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body" id="customers_data">

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
    function editContacts(id){
        $('#customers_data').html(null);
        $.get("{{ route('contacts.edit', ':id') }}".replace(':id', id), function(data){
            $('#customers_data').html(data);
            $('#edit-customers').modal('show');
        });
    }
</script>
@endsection
