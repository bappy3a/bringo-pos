<form action="{{ route('brands.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" type="text" value="{{ $item->name }}" class="form-control" placeholder="Brand name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" id="" placeholder="Brand description"> {{ $item->description }}</textarea>
    </div>
    <div class="modal-footer-btn">
        <button type="submit" class="btn btn-submit">Submit</button>
    </div>
</form>