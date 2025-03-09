@include('admin.header')

<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Edit Feedback</h2>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $feedback->name }}" required>
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="{{ $feedback->position }}" required>
            </div>

            <!-- Feedback Message -->
            <div class="mb-3">
                <label for="message" class="form-label">Feedback</label>
                <textarea class="form-control" id="message" name="message" rows="3" required>{{ $feedback->message }}</textarea>
            </div>

            <!-- Date of Interview -->
            <div class="mb-3">
                <label for="interview_date" class="form-label">Date of Interview</label>
                <input type="date" class="form-control" id="interview_date" name="interview_date" 
                       value="{{ $feedback->interview_date }}">
            </div>

            <!-- Other Information of the Client -->
            <div class="mb-3">
                <label for="client_info" class="form-label">Other Information of the Client</label>
                <textarea class="form-control" id="client_info" name="client_info" rows="3">{{ $feedback->client_info }}</textarea>
            </div>

            <!-- Profile Picture -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Group Photo/Proof of Documentation</label>
                <input type="file" class="form-control" id="image" name="image"  accept="image/*">
                @if($feedback->image)
                    <img src="{{ asset('uploads/' . $feedback->image) }}" class="mt-3 rounded" width="150">
                @endif
            </div>

            <!-- Update Button -->
            <button type="submit" class="btn btn-success">Update Feedback</button>
        </form>
    </div>
</div>

@include('admin.footer')
