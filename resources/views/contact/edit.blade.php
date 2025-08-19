<form action="{{ route('categories.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" type="text" value="{{ $item->name }}" class="form-control" placeholder="Category name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Code</label>
        <input name="code" type="text" value="{{ $item->code }}" class="form-control" placeholder="Category code">
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input name="image" class="form-control" type="file" id="formFile">
        <span class="form-text text-muted">Size 40 * 40 px</span>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" id="" placeholder="Category description"> {{ $item->description }}</textarea>
    </div>
    <div class="modal-footer-btn">
        <button type="submit" class="btn btn-submit">Submit</button>
    </div>
</form>