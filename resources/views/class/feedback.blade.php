<div id="feedback">
    <h2 class="testimonial-title">PROFESSOR'S <span>REVIEWS</span></h2>
    <p class="testimonial-subtitle">Leading the way, setting a powerful example</p>
    <div class="testimonial-slider">
        <button class="prev-btn">&#10094;</button>
        <div class="testimonial-track-wrapper">
            <div class="testimonial-track">
                @foreach ($feedbacks as $feedback)
                    <div class="testimonial-card">
                        <p class="testimonial-text">{{ $feedback->message }}</p>
                        <div class="testimonial-profile">
                            <img src="{{ asset('uploads/' . $feedback->image) }}" alt="Profile">
                            <div class="testimonial-info">
                                <h4>{{ $feedback->name }}</h4>
                                <p>{{ $feedback->position }}</p>
                            </div>
                        </div>
                        <button class="see-more" data-bs-toggle="modal" data-bs-target="#modal-{{ $feedback->id }}">
                            See more
                        </button>

                    </div>

                    <!-- Bootstrap Modal for each feedback -->
                @endforeach
            </div>
        </div>
        <button class="next-btn">&#10095;</button>
    </div>
</div>
