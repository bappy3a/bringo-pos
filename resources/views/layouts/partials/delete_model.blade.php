
<script type="text/javascript">
    function confirm_modal(delete_url)
    {
        jQuery('#confirm-delete').modal('show', {backdrop: 'static'});
        document.getElementById('deleteForm').setAttribute('action', delete_url);
    }
</script>

<div id="confirm-delete" class="modal fade effect-scale" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-centered text-cente">
        <div class="modal-content">
            <div class="modal-body p-4">
                <form id="deleteForm" action="" method="post">
                    @csrf
                    @method('delete')
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <h3 class="mt-2">Confirmation!</h3>
                        <h4 class="mt-2">Are you sure you want to delete this item?</h4>
                        <div class="row my-3">
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6 text-start">
                                <button type="submit" class="btn btn-primary">Delete !</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
