<div class="modal fade" id="editAboutUsModal" tabindex="-1" aria-labelledby="editAboutUsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="editAboutUsModalLabel">Edit About Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if(isset($aboutUs) && $aboutUs->image)
                                <img src="{{ asset('storage/' . $aboutUs->image) }}" width="100">
                            @endif
                        </div>

                        @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-3">
                            <label>Featured Image {{ $i }}</label>
                            <input type="file" name="featured_{{ $i }}" class="form-control" accept="image/*">
                            @if(isset($aboutUs) && $aboutUs->{'featured_' . $i})
                                <img src="{{ asset('storage/' . $aboutUs->{'featured_' . $i}) }}" width="100">
                            @endif
                        </div>
                        @endfor

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

                        <button type="submit" class="btn gradient-button">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>