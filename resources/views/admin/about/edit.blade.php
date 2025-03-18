@include('admin.header')

<div class="page-content">
    <div class="page-header text-white p-3">
        <h2 class="h5 no-margin-bottom">Manage About Us</h2>
    </div>

    <!-- About Us Table -->
    <div class="table-container">
        <h2 class="h5">Existing About Us</h2>
        <table id="uniqueTable" class="styled-table">
            <thead class="bg-success text-white">
                <tr>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Abstract</th>
                    <th>Article Link</th>
                    <th>Background Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $aboutUs->title ?? '' }}</td>
                    <td>{{ $aboutUs->subtitle ?? '' }}</td>
                    <td>{{ $aboutUs->abstract ?? '' }}</td>
                    <td><a href="{{ $aboutUs->article_link ?? '#' }}" target="_blank">View</a></td>
                    <td>
                        @if(isset($aboutUs) && $aboutUs->image)
                            <img src="{{ asset('storage/' . $aboutUs->image) }}" width="100">
                        @endif
                    </td>
                    <td>
                        <button class="btn gradient-button" data-bs-toggle="modal" data-bs-target="#editAboutUsModal">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Edit About Us Modal -->
    @include('admin.modal.aboutusModals')
    @include('admin.footer')
</div>

