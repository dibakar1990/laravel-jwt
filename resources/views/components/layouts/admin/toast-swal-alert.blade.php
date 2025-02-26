<script>
    var Toast = Swal.mixin({
        toast: true,
        icon: 'success',
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>

@if ($message = Session::get('success'))
  <script>
    $( document ).ready(function() {
        Toast.fire({
            icon: 'success',
            title: '{{$message}}'
        })
    });
  </script>
@endif

@if ($message = Session::get('error'))
  <script>
    $( document ).ready(function() {
        Toast.fire({
            icon: 'error',
            title: '{{$message}}'
        })
    });
  </script>
@endif

@if ($message = Session::get('warning'))
  <script>
    $( document ).ready(function() {
        Toast.fire({
            icon: 'warning',
            title: '{{$message}}'
        })
    });
  </script>
@endif