<!-- Modal -->
<div class="modal fade" id="editModalUser" tabindex="-1" aria-labelledby="editModalUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('user.update') }}" method="POST" id="editFormUser">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalUserLabel">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <input type="hidden" name="idUser" id="idUser">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Contoh: budi">
                                <span class="text-danger error-text name_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Contoh: budi@gmail.com">
                                <span class="text-danger error-text email_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select name="roles" id="roles" class="custom-select">
                                    <option>-- Pilih Kategori --</option>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                </select>
                                <span class="text-danger error-text roles_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Contoh: rahasia">
                                <span class="text-danger error-text password_error_edit"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
