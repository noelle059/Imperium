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
        <!-- sssssssssssssssssss -->

        <!-- CL1 CONTROLLER Modal -->
        <div class="modal fade" id="controlModal" tabindex="-1" aria-labelledby="controlModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="controlModalLabel">CL1 Controller</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="card">
                                <label for="switch1"><i class="bi bi-lightbulb" id="icon1"></i> Bulb Control
                                    1</label>
                                <label class="switch">
                                    <input type="checkbox" id="switch1" onclick="toggleSwitch('switch1')">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="card">
                                <label for="switch2"><i class="bi bi-lightbulb" id="icon2"></i> Bulb Control
                                    2</label>
                                <label class="switch">
                                    <input type="checkbox" id="switch2" onclick="toggleSwitch('switch2')">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="card">
                                <label for="switch3"><i class="bi bi-lightbulb" id="icon3"></i> Bulb Control
                                    3</label>
                                <label class="switch">
                                    <input type="checkbox" id="switch3" onclick="toggleSwitch('switch3')">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="card">
                                <label for="switch4"><i class="bi bi-lightbulb" id="icon4"></i> Bulb Control
                                    4</label>
                                <label class="switch">
                                    <input type="checkbox" id="switch4" onclick="toggleSwitch('switch4')">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="card">
                                <label for="outlet"><i class="bi bi-outlet" id="outlet-icon"></i> Outlet
                                    Control</label>
                                <label class="switch">
                                    <input type="checkbox" id="outlet" onclick="toggleSwitch('outlet')">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="button-container">
                            <button class="btn btn-primary power-on-button" onclick="powerOnAll(this)">Power On
                                All</button>
                            <button class="btn btn-secondary power-off-button" onclick="powerOffAll(this)">Power Off
                                All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="timeoutWarningModal" tabindex="-1" aria-labelledby="timeoutWarningModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="timeoutWarningModalLabel">Timeout Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You have exceeded the allowed time in the room. Please check out.
                    </div>
                </div>
            </div>
        </div>


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
