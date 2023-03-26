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
        $('#tableUser').DataTable({
            processing: true,
            info: true,
            serverSide: true,
            ajax: {
                url: "{{ route('fetch.user') }}",
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
                data: 'email',
                name: 'email'
            }, {
                data: 'roles',
                name: 'roles'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        }).on('draw', function() {
            $('input[name="user_checkbox"]').each(function() {
                this.checked = false;
            });

            $('input[name="main_checkbox"]').prop('checked', false);
            $('#delAllButton').addClass('d-none');
        });

        // Ajax store user
        $(document).on('submit', '#addFormUser', function(e) {
            e.preventDefault();
            let dataForm = this;

            $.ajax({
                type: $('#addFormUser').attr('method'),
                url: $('#addFormUser').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#addFormUser').find('span,error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val) {
                            $('#addFormUser').find('span.' + prefix + '_error')
                                .text(val[0]);
                        })
                    } else {
                        Swal.fire(
                            'Suksess', response.success, 'success'
                        );
                        $('#addModalUser').modal('hide');
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        $('#addFormUser')[0].reset();
                    }
                }
            });
        })


        // ajax edit User
        $(document).on('click', '#btnEditUser', function(e) {

            e.preventDefault();
            let idUser = $(this).data('id');

            $.get("{{ route('user.edit') }}", {
                idUser: idUser
            }, function(data) {
                $('#editModalUser').modal('show');
                $('#idUser').val(idUser);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#roles').val(data.user.roles);
            });
        });

        // ajax update user
        $(document).on('submit', '#editFormUser', function(e) {
            e.preventDefault();
            let dataForm = this;

            $.ajax({
                type: $('#editFormUser').attr('method'),
                url: $('#editFormUser').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormUser').find('span,error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val) {
                            $('#editFormUser').find('span.' + prefix +
                                '_error_edit').text(val[0]);
                        })
                    } else {
                        Swal.fire(
                            'Suksess', response.success, 'success'
                        );
                        $('#editModalUser').modal('hide');
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        $('#editFormUser')[0].reset();
                    }
                }
            });
        })

        // Ajax Delete Data User
        $(document).on('click', '#btnDelUser', function(e) {
            e.preventDefault();
            let idUser = $(this).data('id');

            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: 'Kamu Ingin Menghapus Data Pengguna !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: ' #d33',
                confirmButtonText: 'Ya, Hapus',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('user.destroy') }}", {
                        idUser: idUser
                    }, function(data) {
                        Swal.fire(
                            'Suksess', data.success, 'success'
                        )
                        $('#tableUser').DataTable().ajax.reload(null, false);
                    }, "json")
                }
            });
        });

        function toggleDelAllButton() {
            if ($('input[name="user_checkbox"]:checked').length > 0) {
                $('#delAllButton').text('Hapus (' + $("input[name=user_checkbox]:checked").length + ')')
                    .removeClass('d-none');
            } else {
                $('#delAllButton').addClass('d-none');
            }
        }

        $(document).on('click', "#main_checkbox", function() {
            if (this.checked) {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = true;
                })
            } else {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = false;
                })
            }
            toggleDelAllButton();
        });

        $(document).on('click', "#user_checkbox", function() {
            if ($('input[name="user_checkbox"]').length == $('input[name="user_checkbox"]:checked')
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
            let idUsers = [];

            $('input[name="user_checkbox"]:checked').each(function() {
                idUsers.push($(this).data('id'));
                // console.log(idUsers);

                if (idUsers.length > 0) {
                    Swal.fire({
                        title: 'Apakah Kamu Yakin ?',
                        icon: 'warning',
                        html: `Kamu Ingin Hapus (<b>${idUsers.length}</b>) Data Users`,
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
                            $.post("{{ route('user.destroy.selected') }}", {
                                idUsers: idUsers
                            }, function(data) {
                                Swal.fire(
                                    'Suksess', data.success, 'success'
                                )
                                $('#tableUser').DataTable().ajax.reload(null,
                                    false);
                            }, "json");
                        }
                    })
                }
            })
        })





















        // $('#tableUser').DataTable({
        //   responsive: true,
        //   lengthCase: true,
        //   autoWidth: true,
        //   paging: true,
        //   searching: true,
        //   ordering: true,
        //   info: true
        // })
    });
</script>
