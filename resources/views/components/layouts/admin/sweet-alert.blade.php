@if ($message = Session::get('success'))
<script>
   Swal.fire({
            title: "Success!",
            text: "{{$message}}",
            icon: "success",
            customClass: {
                confirmButton: "btn btn-primary waves-effect waves-light"
            },
            buttonsStyling: !1
        })
</script>
@endif

@if ($message = Session::get('error'))
<script>
    Swal.fire({
            title: "Error!",
            text: "{{$message}}",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary waves-effect waves-light"
            },
            buttonsStyling: !1
        })
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    Swal.fire({
            title: "Warning!",
            text: "{{$message}}",
            icon: "warning",
            customClass: {
                confirmButton: "btn btn-primary waves-effect waves-light"
            },
            buttonsStyling: !1
        })
</script>
@endif