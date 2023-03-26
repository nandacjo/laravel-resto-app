  <!-- Tabel User -->
  <div class="row">
      <div class="col-md-12 col-sm-12">
          <div class="card">
              <div class="card-body">
                  <div class="row mb-3">
                      <div class="col-md-6">
                          <ul class="nav nav-pills">
                              <li class="nav-item">
                                  <button class="btn btn-primary" type="button" data-toggle="modal"
                                      data-target="#addModalCategory ">
                                      <span class="fas fa-plus"></span> Tambah Kategori
                                  </button>
                              </li>
                              <div class="nav-item">
                                  <a href="{{ route('category.trash.category') }}" class="nav-link">
                                      <span class="fas fa-trash-restore"></span> Trash</a>
                              </div>
                          </ul>
                      </div>
                  </div>
                  <div class="row mb-3">
                      <div class="col-md-12 sm-md-12 table-responsive">
                          <table id="tableCategory" class="table-bordered table-striped table">
                              <thead>
                                  <tr>
                                      <th>
                                          <input type="checkbox" name="main_checkbox" id="main_checkbox">
                                          <label for=""></label>
                                      </th>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Slug</th>
                                      <th>
                                          Action
                                          <br>
                                          <button id="delAllButton" type="submit"
                                              class="btn btn-sm btn-danger">Hapus</button>
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Tabel User -->
