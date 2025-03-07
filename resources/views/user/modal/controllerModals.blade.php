{{-- ROOM 1 --}}
<div class="modal fade" id="controlModal" tabindex="-1" aria-labelledby="controlModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="controlModal">CL1 Controller</h5>
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
