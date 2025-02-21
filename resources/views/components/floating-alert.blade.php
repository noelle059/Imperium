@if($message)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning', // You can change this to 'success', 'error', etc.
                title: 'Warning',
                text: '{{ $message }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif