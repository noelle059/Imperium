{{-- ADD SCHEDULE ALERT --}}
<script>
    // Id of Button Submit
    document.getElementById('AddScheduleButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form input values
        const ClassroomName = document.querySelector('[name="classroom_id"]').value;
        const ProfessorName = document.querySelector('[name="user_id"]')
            .value; // Get the value of the professor select
        const SubjectName = document.querySelector('[name="subject_id"]')
            .value; // Get the value of the subject select
        const Date = document.querySelector('[name="date"]').value;
        const StartTime = document.querySelector('[name="start_time"]').value;
        const EndTime = document.querySelector('[name="end_time"]').value;

        // Validate if all required fields are filled
        if (!ClassroomName || !ProfessorName || !SubjectName || !Date || !StartTime || !EndTime) {
            // If any field is empty, show a SweetAlert error
            let errorMessage = "Please enter the following fields: ";

            // Adding missing fields to the error message
            if (!ClassroomName) errorMessage += "Classroom, ";
            if (!ProfessorName) errorMessage += "Professor, ";
            if (!SubjectName) errorMessage += "Subject, ";
            if (!Date) errorMessage += "Date, ";
            if (!StartTime) errorMessage += "Start Time, ";
            if (!EndTime) errorMessage += "End Time, ";

            // Remove last comma and space if there are any missing fields
            errorMessage = errorMessage.replace(/, $/, "");

            // Show the SweetAlert with the missing fields
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
                text: 'Do you want to add the schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Add Schedule',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('AddScheduleForm').submit();
                }
            });
        }
    });
</script>
