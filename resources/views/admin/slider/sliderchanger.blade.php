<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header')

<!-- DASHBOARD -->
<div class="page-content">
    <div class="page-header  text-white p-3">
        <h2 class="h5 no-margin-bottom">Manage Slider Images</h2>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px; color: #123524;">
        <button class="btn gradient-button" style="display: flex; align-items: center;" data-bs-toggle="modal"
            data-bs-target="#uploadSliderModal"> <i class="fa fa-plus" style="margin-right: 5px;"></i>
        </button>
    </div>

    <!-- Current Slider Images -->
    <div class="table-container">
        <table id="uniqueTable" class="styled-table">
            <thead class="bg-success text-white">
                <tr>
                    <th>No.</th>
                    <th>Slider Image</th>
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $index => $image)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('images/' . $image->filename) }}" class="img-thumbnail" width="200">
                        </td>
                        <td>{{ \Carbon\Carbon::parse($image->created_at)->format('F j, Y g:i A') }}</td>
                        <td>
                            <form action="{{ route('admin.slider.destroy', $image->id) }}" method="POST"
                                class="delete-form d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn gradient-button delete-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('admin.modal.sliderModal')

    @include('admin.footer')

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-button").forEach(button => {
            button.addEventListener("click", function() {
                let form = this.closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "",
                    cancelButtonColor: "",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });
</script>
