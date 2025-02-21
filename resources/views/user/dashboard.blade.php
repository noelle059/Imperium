<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashoard</title>
    
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Firebase SDK (Modular approach for v9 and above) -->
    <script type="module" src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
   

<div class="container">
    <!-- Navbar-->
    @include('layouts.navigation')


<div class="container mt-5">
    <h2>Classroom</h2>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Room</th>
                <th>Professor Name</th>
                <th>Status</th>
                <th>Time</th>
                <th>Controller</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CL1</td>
                <td>Dr. Smith</td>
                <td>Available</td>
                <td>09:00 - 10:00</td>
                <td>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#controlModal">Remote</button>
                </td>
            </tr>
            


            
        </tbody>
    </table>
</div>

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
                        <label for="switch1"><i class="bi bi-lightbulb" id="icon1"></i> Control 1</label>
                        <label class="switch">
                            <input type="checkbox" id="switch1" onclick="toggleSwitch('switch1')">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="card">
                        <label for="switch2"><i class="bi bi-lightbulb" id="icon2"></i> Control 2</label>
                        <label class="switch">
                            <input type="checkbox" id="switch2" onclick="toggleSwitch('switch2')">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="card">
                        <label for="switch3"><i class="bi bi-lightbulb" id="icon3"></i> Control 3</label>
                        <label class="switch">
                            <input type="checkbox" id="switch3" onclick="toggleSwitch('switch3')">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="card">
                        <label for="switch4"><i class="bi bi-lightbulb" id="icon4"></i> Control 4</label>
                        <label class="switch">
                            <input type="checkbox" id="switch4" onclick="toggleSwitch('switch4')">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="card">
                        <label for="outlet"><i class="bi bi-outlet" id="outlet-icon"></i> Control</label>
                        <label class="switch">
                            <input type="checkbox" id="outlet" onclick="toggleSwitch('outlet')">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="button-container">
                    <button class="btn btn-primary power-on-button" onclick="powerOnAll(this)">Power On All</button>
                    <button class="btn btn-secondary power-off-button" onclick="powerOffAll(this)">Power Off All</button>
                </div>
            </div>
        </div>
    </div>
</div>



 <!--PATH: PUBLIC: BUTTON JS -->
 <script src="button.js"></script>


 <!-- Bootstrap Bundle JS (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>