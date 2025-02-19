@if($message)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info', // You can change this to 'success', 'error', etc.
                title: 'Notification',
                text: '{{ $message }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif