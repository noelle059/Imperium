// Replace these with your actual Firebase references
const switchRef1 = "switch1_state";
const switchRef2 = "switch2_state";
const switchRef3 = "switch3_state";
const switchRef4 = "switch4_state";
const outletRef = "outlet_state";

// Define the 'set' function (Placeholder - Adapt for your database)
function set(ref, value) {
    console.log(`Setting ${ref} to ${value}`);
    // Replace this with your actual database update logic (e.g., Firebase)
    // Example (Illustrative - Adapt to your Firebase setup):
    // firebase.database().ref(ref).set(value).then(() => {
    //     console.log("Successfully updated:", ref, "to", value);
    // }).catch(error => {
    //     console.error("Error updating:", ref, error);
    // });
}


function getSwitchState(switchId) {
    const element = document.getElementById(switchId);
    if (element) {
        return element.checked;
    } else {
        console.warn(`Element with id ${switchId} not found.`);
        return false; // or handle the missing element differently
    }
}

function toggleSwitch(switchId) {
    const element = document.getElementById(switchId);
    if (element) {
        console.log(`Switch ${switchId} is now: ${element.checked}`);
    } else {
        console.warn(`Element with id ${switchId} not found.`);
    }
}


function checkAndControl() {
    const switch1State = getSwitchState('switch1');
    const switch2State = getSwitchState('switch2');
    const switch3State = getSwitchState('switch3');
    const switch4State = getSwitchState('switch4');
    const outletState = getSwitchState('outlet');

    const allTrue = switch1State && switch2State && switch3State && switch4State && outletState;
    const allFalse = !switch1State && !switch2State && !switch3State && !switch4State && !outletState;

    const powerOnButton = document.querySelector('.power-on-button');
    const powerOffButton = document.querySelector('.power-off-button');

    if (allTrue) {
        powerOffButton.classList.add('active');
        powerOnButton.classList.remove('active');
    } else if (allFalse) {
        powerOnButton.classList.add('active');
        powerOffButton.classList.remove('active');
    } else {
        powerOnButton.classList.remove('active');
        powerOffButton.classList.remove('active');
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // Event listeners for switches
    const switchIds = ['switch1', 'switch2', 'switch3', 'switch4', 'outlet'];
    switchIds.forEach(id => {
        const switchElement = document.getElementById(id);
        if (switchElement) {
            switchElement.addEventListener('change', checkAndControl);
        } else {
            console.warn(`Switch with id ${id} not found.`);
        }
    });

    // Event listeners for buttons
    const powerOnButton = document.querySelector('.power-on-button');
    const powerOffButton = document.querySelector('.power-off-button');

    if (powerOnButton) {
        powerOnButton.addEventListener('click', function () {
            powerOnAll(powerOnButton);
        });
    }
    
    if (powerOffButton) {
        powerOffButton.addEventListener('click', function () {
            powerOffAll(powerOffButton);
        });
    }

    // Initial check when the page loads
    checkAndControl();
});

function toggleSwitch(switchId) {
    const element = document.getElementById(switchId);
    if (element) {
        console.log(`Switch ${switchId} is now: ${element.checked}`);
    } else {
        console.warn(`Element with id ${switchId} not found.`);
    }
}



function powerOnAll(button) {
    // Set all switches and outlet to on
    document.getElementById('switch1').checked = true;
    document.getElementById('switch2').checked = true;
    document.getElementById('switch3').checked = true;
    document.getElementById('switch4').checked = true;
    document.getElementById('outlet').checked = true;

    toggleSwitch('switch1');
    toggleSwitch('switch2');
    toggleSwitch('switch3');
    toggleSwitch('switch4');
    toggleSwitch('outlet');

    set(switchRef1, true);
    set(switchRef2, true);
    set(switchRef3, true);
    set(switchRef4, true);
    set(outletRef, true);

    // Update button states
    if (button) {
        button.classList.add('active');
    }
    const powerOffButton = document.querySelector('.power-off-button');
    if (powerOffButton) {
        powerOffButton.classList.remove('active');
    }
}

function powerOffAll(button) {
    // Set all switches and outlet to off
    document.getElementById('switch1').checked = false;
    document.getElementById('switch2').checked = false;
    document.getElementById('switch3').checked = false;
    document.getElementById('switch4').checked = false;
    document.getElementById('outlet').checked = false;

    toggleSwitch('switch1');
    toggleSwitch('switch2');
    toggleSwitch('switch3');
    toggleSwitch('switch4');
    toggleSwitch('outlet');

    set(switchRef1, false);
    set(switchRef2, false);
    set(switchRef3, false);
    set(switchRef4, false);
    set(outletRef, false);

    // Update button states
    if (button) {
        button.classList.add('active');
    }
    const powerOnButton = document.querySelector('.power-on-button');
    if (powerOnButton) {
        powerOnButton.classList.remove('active');
    }
}

// Attach event listeners to your switches (e.g., on change) or call checkAndControl periodically
document.getElementById('switch1').addEventListener('change', checkAndControl);
document.getElementById('switch2').addEventListener('change', checkAndControl);
document.getElementById('switch3').addEventListener('change', checkAndControl);
document.getElementById('switch4').addEventListener('change', checkAndControl);
document.getElementById('outlet').addEventListener('change', checkAndControl);

// Initial check when the page loads
checkAndControl();

// Add event listeners to your buttons.
document.addEventListener('DOMContentLoaded', function() {
    const powerOnButton = document.querySelector('.power-on-button');
    const powerOffButton = document.querySelector('.power-off-button');

    if (powerOnButton) {
        powerOnButton.addEventListener('click', function() {
            powerOnAll(powerOnButton);
        });
    }

    if (powerOffButton) {
        powerOffButton.addEventListener('click', function() {
            powerOffAll(powerOffButton);
        });
    }
});