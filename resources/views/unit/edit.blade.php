<form action="{{ route('units.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" value="{{ $item->name }}" type="text" class="form-control" placeholder="Unit name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Allow decimal</label>
        <select name="allow_decimal" class="form-select" required>
            <option @if($item->allow_decimal == 1) selected @endif value="1">Yes</option>
            <option @if($item->allow_decimal == 0) selected @endif value="0">No</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" id="" placeholder="Unit description">{{ $item->description }}</textarea>
    </div>
    <div class="modal-footer-btn">
        <button type="submit" class="btn btn-submit">Submit</button>
    </div>
</form>