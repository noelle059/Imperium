<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header') 

<!-- DASHBOARD -->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Manage Feedback</h2>
        </div>
    </div>

   <!-- Add New Feedback -->
<div class="container-fluid">
<form action="{{ route('admin.feedback.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name of the Consultant</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="position" class="form-label">Position</label>
        <input type="text" class="form-control" id="position" name="position" required>
    </div>

    <div class="mb-3">
        <label for="message" class="form-label">Feedback</label>
        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="interview_date" class="form-label">Date of Interview</label>
        <input type="date" class="form-control" id="interview_date" name="interview_date">
    </div>

    <div class="mb-3">
        <label for="client_info" class="form-label">Other Information of the Client</label>
        <textarea class="form-control" id="client_info" name="client_info" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Upload Group Photo/Proof of Documentation</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Add Feedback</button>
</form>

</div>

    <!-- Current Feedback -->
    <div class="container-fluid mt-5">
        <h2>Existing Feedback</h2>
        <div class="row">
            @foreach($feedbacks as $feedback)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('uploads/' . $feedback->image) }}" class="card-img-top" alt="Profile Picture">
                        <div class="card-body">
                            <h5 class="card-title">{{ $feedback->name }}</h5>
                            <p class="card-text"><strong>{{ $feedback->position }}</strong></p>
                            <p class="card-text">"{{ $feedback->feedback }}"</p>

                            <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                            <a href="{{ route('admin.feedback.edit', $feedback->id) }}" class="btn btn-warning mt-2">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- FOOTER -->
@include('admin.footer')
