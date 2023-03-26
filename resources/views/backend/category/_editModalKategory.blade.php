<!-- Modal -->
<div class="modal fade" id="editModalCategory" tabindex="-1" aria-labelledby="addModalCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('category.update') }}" method="POST" id="editFormCategory">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalCategoryLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="hidden" name="idCategory" id="idCategory">

                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Contoh: Steak">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
