<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashoard</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Firebase SDK (Modular approach for v9 and above) -->
    <script type="module" src="/scripts/remote_script.js"></script>
    <script type="module" src="/scripts/dynamicRemoteScript.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        body {
            background-image: url('/images/CLASSROOM_BACKGROUND.svg');
            /* Adjust the path if necessary */
            background-size: cover;
            /* Cover the entire viewport */
            background-repeat: no-repeat;
            /* Prevent tiling */
            background-position: center;
            /* Center the image */
        }
    </style>


</head>

<body>
    <x-floating-alert :message="session('alert')" />
    <div class="container">
        <!-- Navbar-->
        @include('layouts.navigation')

        <div class="container mt-5">
            <h2 style ="color: white">Classroom</h2>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Room</th>
                        <th>Professor Name</th>
                        <th>Status</th>
                        <th>Time-in</th>
                        <th>Controller</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr id="room-{{ $room->id }}">
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->professor_name ?? 'N/A' }}</td>
                            <td>{{ $room->status }}</td>
                            <td>{{ $room->time_in ?? 'N/A' }}</td>
                            <td>
                                <button
                                    class="btn
                                    @if ($room->button_status == 'Remote') btn-success
                                    @elseif($room->button_status == 'Occupied') btn-warning
                                    @else btn-danger @endif
                                    btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#controlModal"
                                    {{ $room->button_status == 'Remote' ? '' : 'disabled' }}>
                                    {{ $room->button_status }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>





        <!-- INCLUDE MODALS -->
        @include('user.modal.controllerModals')





        <div class="modal fade" id="timeoutWarningModal" tabindex="-1" aria-labelledby="timeoutWarningModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeoutWarningModalLabel">Timeout Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You have exceeded the allowed time in the room. Please check out.
                    </div>
                </div>
            </div>
        </div>










        {{-- FOOTER CDN LINKS --}}

        <!--PATH: PUBLIC: BUTTON JS -->
        <script src="/scripts/button.js"></script>


        <!-- Bootstrap Bundle JS (Includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <script>
            @if (session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            @endif
        </script>
</body>

</html>
