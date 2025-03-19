@foreach ($feedbacks as $feedback)
    <div class="modal fade" id="modal-{{ $feedback->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $feedback->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="feedback-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel-{{ $feedback->id }}">{{ $feedback->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <img src="{{ asset('uploads/' . $feedback->image) }}" class="img-fluid rounded w-50"
                        alt="Feedback Image">

                    <p class="mt-3 fw-bold">{{ $feedback->position }}</p>
                    <p class="fst-italic">"{{ $feedback->message }}"</p>

                    <div class="text-center p-3 mt-4">
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/CSD_ICON.svg') }}" alt="Icon" class="rounded-circle me-2"
                                width="30">
                            <div>
                                <h6 class="mb-1 text-uppercase text-muted" style="font-size: 0.9rem;">Date of Interview
                                </h6>
                                <p class="mb-0 fw-bold" style="font-size: 1rem;">
                                    {{ $feedback->interview_date ?? 'Not Provided' }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center mt-3">
                            <img src="{{ asset('images/CSD_ICON.svg') }}" alt="Icon" class="rounded-circle me-2"
                                width="30">
                            <div>
                                <h6 class="mb-1 text-uppercase text-muted" style="font-size: 0.9rem;">Other Information
                                    of the Client</h6>
                                <p class="mb-0 fw-bold" style="font-size: 1rem;">
                                    {{ $feedback->client_info ?? 'No additional information' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
