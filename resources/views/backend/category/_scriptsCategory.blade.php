<!-- Sweetalert js  -->
<script src="{{ asset('sweetalert/sweetalert2.min.js') }}"></script>

<!-- Library Datatable  -->
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {

        // Csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Menampilkan data user menggunakan yazra
        $('#tableCategory').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: {
                url: "{{ route('fetch.category') }}",
                type: 'GET'
            },
            columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            }, {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'slug',
                name: 'slug'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        }).on('draw', function() {
            $('input[name="category_checkbox"]').each(function() {
                this.checked = false;
            });

            $('input[name="main_checkbox"]').prop('checked', false);
            $('#delAllButton').addClass('d-none');
        });


        // Ajax add category
        $(document).on('submit', '#addFormCategory', function(e) {
            e.preventDefault();
            let dataForm = this;

            $.ajax({
                type: $('#addFormCategory').attr('method'),
                url: $('#addFormCategory').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#addFormCategory').find('span,error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val) {
                            $('#addFormCategory').find('span.' + prefix + '_error')
                                .text(val[0]);
                        })
                    } else {
                        Swal.fire(
                            'Suksess', response.success, 'success'
                        );
                        $('#addModalCategory').modal('hide');
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        $('#addFormCategory')[0].reset();
                    }
                }
            });
        })

        // Ajax Delete Data User
        $(document).on('click', '#btnDelCategory', function(e) {
            e.preventDefault();
            let idCategory = $(this).data('id');

            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: 'Kamu Ingin Menghapus Data Kategori !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: ' #d33',
                confirmButtonText: 'Ya, Hapus',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('category.destroy') }}", {
                        idCategory: idCategory
                    }, function(data) {
                        Swal.fire(
                            'Suksess', data.success, 'success'
                        )
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                    }, "json")
                }
            });
        });

        // Ajax Edit Category
        $(document).on('click', '#btnEditCategory', function(e) {

            e.preventDefault();
            let idCategory = $(this).data('id');

            $.get("{{ route('category.edit') }}", {
                idCategory: idCategory
            }, function(data) {
                $('#editModalCategory').modal('show');
                $('#idCategory').val(idCategory);
                $('#name').val(data.category.name);
            }, "json");
        });

        // Ajax Update Category
        $(document).on('submit', '#editFormCategory', function(e) {
            e.preventDefault();
            let dataForm = this;

            $.ajax({
                type: $('#editFormCategory').attr('method'),
                url: $('#editFormCategory').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormCategory').find('span,error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val) {
                            $('#editFormCategory').find('span.' + prefix +
                                '_error_edit').text(val[0]);
                        })
                    } else {
                        Swal.fire(
                            'Suksess', response.success, 'success'
                        );
                        $('#editModalCategory').modal('hide');
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        $('#editFormCategory')[0].reset();
                    }
                }
            });
        })

        // Menampilkan Trash Category
        // Menampilkan data user menggunakan yazra
        $('#tableCategoryTrash').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: {
                url: "{{ route('category.fetch.trash.category') }}",
                type: 'GET'
            },
            columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            }, {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'slug',
                name: 'slug'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        }).on('draw', function() {
            $('input[name="category_trash_checkbox"]').each(function() {
                this.checked = false;
            });

            $('input[name="main_trash_checkbox"]').prop('checked', false);
            $('#delAllButton').addClass('d-none');
        });

        function toggleDelAllButton() {
            if ($('input[name="category_checkbox"]:checked').length > 0) {
                $('#delAllButton').text('Hapus (' + $("input[name=category_checkbox]:checked").length + ')')
                    .removeClass('d-none');
            } else {
                $('#delAllButton').addClass('d-none');
            }
        }

        $(document).on('click', "#main_checkbox", function() {
            if (this.checked) {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = true;
                })
            } else {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = false;
                })
            }
            toggleDelAllButton();
        });

        $(document).on('click', "#category_checkbox", function() {
            if ($('input[name="category_checkbox"]').length == $(
                    'input[name="category_checkbox"]:checked')
                .length) {
                $('#main_checkbox').prop('checked', true);
            } else {
                $('#main_checkbox').prop('checked', false);
            }
            toggleDelAllButton();
        })

        // Ajax multiple delete
        $(document).on('click', '#delAllButton', function(e) {
            e.preventDefault();
            let idCategory = [];

            $('input[name="category_checkbox"]:checked').each(function() {
                idCategory.push($(this).data('id'));
                // console.log(idUsers);

                if (idCategory.length > 0) {
                    Swal.fire({
                        title: 'Apakah Kamu Yakin ?',
                        icon: 'warning',
                        html: `Kamu Ingin Hapus (<b>${idCategory.length}</b>) Data Category`,
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Tidak',
                        confirmButtonColor: '#556ee6',
                        cancelButtonColor: '#d33',
                        width: 350,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('category.destroy.selected') }}", {
                                idCategory: idCategory
                            }, function(data) {
                                Swal.fire(
                                    'Suksess', data.success, 'success'
                                )
                                $('#tableCategory').DataTable().ajax.reload(
                                    null,
                                    false);
                            }, "json");
                        }
                    })
                }
            })
        })

        // Ajax Restore Data User
        $(document).on('click', '#btnRestoreCategory', function(e) {
            e.preventDefault();
            let idCategory = $(this).data('id');

            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: 'Kamu Ingin Restore Data Pengguna Ini !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: ' #d33',
                confirmButtonText: 'Ya, Restore',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('category.restore') }}", {
                        idCategory: idCategory
                    }, function(data) {
                        Swal.fire(
                            'Suksess', data.success, 'success'
                        )
                        $('#tableCategoryTrash').DataTable().ajax.reload(null, false);
                    }, "json")
                }
            });
        });


    });
</script>
