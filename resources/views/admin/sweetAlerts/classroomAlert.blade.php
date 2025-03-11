{{-- ADD CLASSROOM ALERT --}}
<script>
    // Id of Button Submit
    document.getElementById('AddClassroomButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const ClassroomName = document.querySelector('[name="classroom_name"]').value;
        const FloorSelect = document.querySelector('[name="floor_id"]');
        const FloorID = FloorSelect.value;
        const FloorName = FloorSelect.options[FloorSelect.selectedIndex]
            .text; // Get the text of the selected option


        // Validate if all required fields are filled
        if (!ClassroomName || !FloorID) {
            // If any field is empty, show a SweetAlert error
            let errorMessage = "Please enter the following fields: ";
            if (!ClassroomName) errorMessage += "Classroom Name";
            if (!FloorID) errorMessage += " Floor Level";

            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // If all fields are filled, show the confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to add the classroom ${ClassroomName} on ${FloorName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Classroom',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddClassroomForm').submit();
                }
            });
        }
    });
</script>
