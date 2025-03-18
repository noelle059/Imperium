@include('admin.header')

<div class="page-content">
    <div class="page-header  text-white p-3">
        <h2 class="h5 no-margin-bottom">Manage Footer</h2>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px; color: #123524;">
         <button class="btn gradient-button" style="display: flex; align-items: center;" type="button"
             data-bs-toggle="modal" data-bs-target="#editFooterModal">
             <i class="fa fa-edit" style="margin-right: 5px;"></i> Edit Footer
         </button>

       </div>

    <!-- Current Footer Content -->
    <div class="container-fluid p-4">
        <h2 h2 class="h5" style="color: #123524;">Current Footer Content</h2>
        <table id="uniqueTable" class="styled-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Featured Images</th>
                    <th>Address</th>
                    <th>Map</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $footerContent->description ?? 'No description available' }}</td>
                    <td>
                        @if(!empty($footerContent->featured_1))
                            <img src="{{ asset('storage/' . $footerContent->featured_1) }}" width="50">
                        @endif
                        @if(!empty($footerContent->featured_2))
                            <img src="{{ asset('storage/' . $footerContent->featured_2) }}" width="50">
                        @endif
                        @if(!empty($footerContent->featured_3))
                            <img src="{{ asset('storage/' . $footerContent->featured_3) }}" width="50">
                        @endif
                    </td>
                    <td>{{ $footerContent->address ?? 'No address available' }}</td>
                    <td>
                        @if(!empty($footerContent->map_url))
                            <a href="{{ $footerContent->map_url }}" target="_blank">View Map</a>
                        @else
                            No map available
                        @endif
                    </td>
                    <td>
                        <button class="btn gradient-button" data-bs-toggle="modal" data-bs-target="#editFooterModal">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('admin.modal.editFooterModal')

    @include('admin.footer')
</div>

