@foreach($feedbacks as $feedback)
<div class="modal fade" id="editFeedbackModal{{ $feedback->id }}" tabindex="-1" aria-labelledby="editFeedbackModalLabel{{ $feedback->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="editFeedbackModalLabel{{ $feedback->id }}">Edit Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name{{ $feedback->id }}" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="name{{ $feedback->id }}" name="name" value="{{ $feedback->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="position{{ $feedback->id }}" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position{{ $feedback->id }}" name="position" value="{{ $feedback->position }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="message{{ $feedback->id }}" class="form-label">Feedback</label>
                        <textarea class="form-control" id="message{{ $feedback->id }}" name="message" rows="3" required>{{ $feedback->message }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="interview_date{{ $feedback->id }}" class="form-label">Date of Interview</label>
                        <input type="date" class="form-control" id="interview_date{{ $feedback->id }}" name="interview_date" value="{{ $feedback->interview_date }}">
                    </div>

                    <div class="mb-3">
                        <label for="client_info{{ $feedback->id }}" class="form-label">Other Information of the Client</label>
                        <textarea class="form-control" id="client_info{{ $feedback->id }}" name="client_info" rows="3">{{ $feedback->client_info }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image{{ $feedback->id }}" class="form-label">Upload Group Photo/Proof of Documentation</label>
                        <input type="file" class="form-control" id="image{{ $feedback->id }}" name="image" accept="image/*">
                        @if($feedback->image)
                            <img src="{{ asset('uploads/' . $feedback->image) }}" class="mt-3 rounded" width="150">
                        @endif
                    </div>

                    <button type="submit" class="btn gradient-button">Update Feedback</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
