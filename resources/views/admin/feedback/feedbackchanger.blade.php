<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header')

<!-- DASHBOARD -->
<div class="page-content">
    <div class="page-header text-white p-3"> 
        <h2 class="h5 no-margin-bottom">Manage Feedback</h2>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 0px; padding-right: 20px; color: #123524;">
         <button class="btn gradient-button" style="display: flex; align-items: center;" type="button"
             data-bs-toggle="modal" data-bs-target="#addFeedbackModal">
             <i class="fa fa-plus" style="margin-right: 5px;"></i> Add Feedback
         </button>
     </div>
    <!-- Include Feedback Modal -->
    @include('admin.modal.feedbackaddModals')
    @include('admin.modal.editFeedbackModal')


    <!-- Current Feedback -->
    <div class="table-container">
        <h2 class="h5" style="color: #123524;">Existing Feedback</h2>
        <table id="uniqueTable" class="styled-table">
            <thead class="bg-success text-white">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Feedback</th>
                    <th>Interview Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $index => $feedback)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $feedback->name }}</td>
                    <td>{{ $feedback->position }}</td>
                    <td>{{ $feedback->message }}</td>
                    <td>{{ $feedback->interview_date }}</td>
                    <td>

                    <button class="btn gradient-button"  type="button" data-bs-toggle="modal" data-bs-target="#editFeedbackModal{{ $feedback->id }}">
    <i class="fa fa-edit" style="margin-right: 5px;"></i> Edit
</button>
                        <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn gradient-button">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('admin.footer')

</div>

