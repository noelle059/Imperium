 <!-- Edit Footer Modal -->
 <div class="modal fade" id="editFooterModal" tabindex="-1" aria-labelledby="editFooterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="editFooterModalLabel">Edit Footer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.footer.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ $footerContent->description ?? '' }}</textarea>
                        </div>

                        @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-3">
                            <label>Featured Image {{ $i }}</label>
                            <input type="file" name="featured_{{ $i }}" class="form-control" accept="image/*">
                            @if(!empty($footerContent->{'featured_' . $i}))
                                <img src="{{ asset('storage/' . $footerContent->{'featured_' . $i}) }}" width="100" class="mt-2">
                            @endif
                        </div>
                        @endfor

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $footerContent->address ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="map_url">Google Maps URL</label>
                            <input type="text" name="map_url" class="form-control" value="{{ $footerContent->map_url ?? '' }}">
                        </div>

                        <button type="submit" class="btn gradient-button">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>