@php
    $type = request()->query('type');
@endphp
<div class="modal fade" id="addNewContacts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if($type == 'customer')
                    <h5 class="modal-title" id="staticBackdropLabel">Crete new customer</h5>
                @elseif($type == 'supplier')
                    <h5 class="modal-title" id="staticBackdropLabel">Crete new supplier</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                <form action="{{ route('contacts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="customer">Customer</option>
                            <option value="supplier">Supplier</option>
                            <option value="both">Both (Supplier & Customer)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">email</label>
                        <input name="email" type="email" class="form-control" placeholder="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">phone</label>
                        <input name="phone" type="tel" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">address</label>
                        <input name="address" type="text" class="form-control" placeholder="Full address">
                    </div>
                    <div class="modal-footer-btn">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
