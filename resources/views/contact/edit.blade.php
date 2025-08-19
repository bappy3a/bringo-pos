<form action="{{ route('contacts.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
            <option value="customer" {{ $item->type == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="supplier" {{ $item->type == 'supplier' ? 'selected' : '' }}>Supplier</option>
            <option value="both" {{ $item->type == 'both' ? 'selected' : '' }}>Both (Supplier & Customer)</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" type="text" class="form-control" placeholder="Name" required value="{{ $item->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input name="email" type="email" class="form-control" placeholder="Email Address" value="{{ $item->email }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input name="phone" type="tel" class="form-control" placeholder="Phone Number" value="{{ $item->phone }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Address (Optional)</label>
        <input name="address" type="text" class="form-control" placeholder="Full address" value="{{ $item->address }}">
    </div>
    <div class="modal-footer-btn">
        <button type="submit" class="btn btn-submit">Update</button>
    </div>
</form>