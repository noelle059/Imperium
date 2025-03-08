@include('admin.header') 

<div class="container mt-4" style="min-height: 100vh; padding-bottom: 100px;">
    <h2>Edit Footer</h2>
    <form action="{{ route('admin.footer.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Logo -->
        <div class="mb-3">
            <label for="logo">Logo</label>
            <input type="text" name="logo" class="form-control" value="{{ $footerContent->logo ?? '' }}">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $footerContent->description ?? '' }}</textarea>
        </div>

        <!-- Featured Images -->
        <div class="mb-3">
            <label>Featured Image 1</label>
            <input type="file" name="featured_1" class="form-control"  accept="image/*">
            @if(!empty($footerContent->featured_1))
                <img src="{{ asset('storage/' . $footerContent->featured_1) }}" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Featured Image 2</label>
            <input type="file" name="featured_2" class="form-control" accept="image/*">
            @if(!empty($footerContent->featured_2))
                <img src="{{ asset('storage/' . $footerContent->featured_2) }}" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Featured Image 3</label>
            <input type="file" name="featured_3" class="form-control" accept="image/*">
            @if(!empty($footerContent->featured_3))
                <img src="{{ asset('storage/' . $footerContent->featured_3) }}" width="100" class="mt-2">
            @endif
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $footerContent->address ?? '' }}">
        </div>

        <!-- Google Maps URL -->
        <div class="mb-3">
            <label for="map_url">Google Maps URL</label>
            <input type="text" name="map_url" class="form-control" value="{{ $footerContent->map_url ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

@include('admin.footer')
