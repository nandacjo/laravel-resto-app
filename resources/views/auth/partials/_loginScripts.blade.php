<!-- Sweetalert js  -->
<script src="{{ asset('sweetalert/sweetalert2.min.js') }}"></script>

<script>
  $(document).ready(function() {
    // logic untuk menampilkan password
    $(document).on('click', '#checkbox', function() {
      if ($(this).is(':checked')) {
        console.log('hellow world');
        $('#password').attr('type', 'text')
      } else {
        $('#password').attr('type', 'password')
      }
    })

    // csrf token ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Login menggunakan ajax
    $(document).on('submit', '#formLogin', function(e) {
      e.preventDefault();
      let dataForm = this;

      $.ajax({
        type: $("#formLogin").attr('method')
        , url: $("#formLogin").attr('action')
        , data: new FormData(dataForm),
        // console.log(data),
        dataType: "json"
        , processData: false
        , contentType: false
        , success: function(response) {
          if (response.status == 405) {
            Swal.fire({
              icon: 'error'
              , title: 'Ooopss!'
              , text: response.error
            , });
            $('#formLogin')[0].reset();
          } else if (response.status == 400) {
            Swal.fire({
              icon: 'error'
              , title: 'Ooopss!'
              , text: response.error
            , });
            $('#formLogin')[0].reset();

          } else {
            window.location.replace("{{ route('dashboard') }}");
          }
        }
      });
    });
  })

</script>
