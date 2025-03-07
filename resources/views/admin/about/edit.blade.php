@include('admin.header') 

<div class="container mt-4" style="min-height: 100vh; padding-bottom: 100px;">
    <h2>Edit About Us</h2>
    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $aboutUs->title ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ $aboutUs->subtitle ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Abstract</label>
            <textarea name="abstract" class="form-control">{{ $aboutUs->abstract ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label>Article Link</label>
            <input type="text" name="article_link" class="form-control" value="{{ $aboutUs->article_link ?? '' }}">
        </div>

        <div class="mb-3">
    <label>Background Image</label>
    <input type="file" name="image" class="form-control">
    @if(isset($aboutUs) && $aboutUs->image)
        <img src="{{ asset('storage/' . $aboutUs->image) }}" width="100">
    @endif
</div>

<div class="mb-3">
    <label>Featured Image 1</label>
    <input type="file" name="featured_1" class="form-control">
    @if(isset($aboutUs) && $aboutUs->featured_1)
        <img src="{{ asset('storage/' . $aboutUs->featured_1) }}" width="100">
    @endif
</div>

<div class="mb-3">
    <label>Featured Image 2</label>
    <input type="file" name="featured_2" class="form-control">
    @if(isset($aboutUs) && $aboutUs->featured_2)
        <img src="{{ asset('storage/' . $aboutUs->featured_2) }}" width="100">
    @endif
</div>

<div class="mb-3">
    <label>Featured Image 3</label>
    <input type="file" name="featured_3" class="form-control">
    @if(isset($aboutUs) && $aboutUs->featured_3)
        <img src="{{ asset('storage/' . $aboutUs->featured_3) }}" width="100">
    @endif
</div>



        <div class="mb-3">
    <label>Modal Title</label>
    <input type="text" name="modal_title" class="form-control" value="{{ $aboutUs->modal_title ?? '' }}">
</div>

<div class="mb-3">
    <label>Modal Subtitle</label>
    <input type="text" name="modal_subtitle" class="form-control" value="{{ $aboutUs->modal_subtitle ?? '' }}">
</div>

<div class="mb-3">
    <label>Modal DOI</label>
    <input type="text" name="modal_doi" class="form-control" value="{{ $aboutUs->modal_doi ?? '' }}">
</div>

<div class="mb-3">
    <label>Modal Meta</label>
    <input type="text" name="modal_meta" class="form-control" value="{{ $aboutUs->modal_meta ?? '' }}">
</div>

<div class="mb-3">
    <label>Modal Abstract</label>
    <textarea name="modal_abstract" class="form-control">{{ $aboutUs->modal_abstract ?? '' }}</textarea>
</div>

<div class="mb-3">
    <label>Modal Article Link</label>
    <input type="text" name="modal_article_link" class="form-control" value="{{ $aboutUs->modal_article_link ?? '' }}">
</div>


        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@include('admin.footer')
