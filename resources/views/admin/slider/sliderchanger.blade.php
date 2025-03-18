<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header')

<!-- DASHBOARD -->
<div class="page-content">
    <div class="page-header  text-white p-3">
        <h2 class="h5 no-margin-bottom">Manage Slider Images</h2>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px; color: #123524;">
        <button class="btn gradient-button" style="display: flex; align-items: center;" data-bs-toggle="modal" data-bs-target="#uploadSliderModal">+ Upload New Slider</button>
    </div>

    <!-- Current Slider Images -->
    <div class="table-container">
        <h2 class="h5" style="color: #123524">Current Slider Images</h2>
        <table id="uniqueTable" class="styled-table">
            <thead class="bg-success text-white">
                <tr>
                    <th>No.</th>
                    <th>Slider Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $index => $image)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ asset('images/' . $image->filename) }}" class="img-thumbnail" width="150">
                    </td>
                    <td>
                        <form action="{{ route('admin.slider.destroy', $image->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"class="btn gradient-button">Remove</button>
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

