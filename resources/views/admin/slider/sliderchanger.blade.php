<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header') 
<!-- DASHBOARD -->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Manage Slider Images</h2>
        </div>
    </div>

    <!-- Upload New Slider Image -->
    <div class="container-fluid">
        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Upload New Slider Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <!-- Current Slider Images -->
    <div class="container-fluid mt-5">
        <h2>Current Slider Images</h2>
        <div class="row">
            @foreach($images as $image)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="{{ asset('images/' . $image->filename) }}" class="card-img-top" alt="Slider Image">
                        <div class="card-body">
                            <form action="{{ route('admin.slider.destroy', $image->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- FOOTER -->
@include('admin.footer')
