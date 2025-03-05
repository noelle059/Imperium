
<x-floating-alert :message="session('alert')" />
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="icon" type="image/svg" href="{{ asset('images/FAVICON_1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/insights.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mediaquery.css') }}">
    <script src="{{ asset('scripts/landingpage.js') }}" defer></script>
    <script src="{{ asset('scripts/feedback.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!--ABOUT-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/abouts/about-2/assets/css/about-2.css">   
    <!--ABOUT-->

    <!--FEEDBACK-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--FEEDBACK-->
    
    <!-- FOOTER -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <link href='//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet'/>
    <!-- FOOTER -->
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">

    @include('class.navbar')
    @include('class.carousel', ['images' => $images])
    @include('class.about')


    @include('class.feedback')

<!-- Move modals to ensure they are inside the actual page -->
@foreach($feedbacks as $feedback)
<div class="modal fade" id="modal-{{ $feedback->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $feedback->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel-{{ $feedback->id }}">{{ $feedback->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <!-- Profile Image -->
                <img src="{{ asset('uploads/' . $feedback->image) }}" class="img-fluid rounded w-50" alt="Feedback Image">
                
                <!-- Position & Message -->
                <p class="mt-3 fw-bold">{{ $feedback->position }}</p>
                <p class="fst-italic">"{{ $feedback->message }}"</p>

                <!-- Interview Date & Client Info Section -->
                <div class="text-center p-3 mt-4">
                    <!-- DATE OF INTERVIEW -->
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/CSD_ICON.svg') }}" alt="Icon" class="rounded-circle me-2" width="30">
                        <div>
                            <h6 class="mb-1 text-uppercase text-muted" style="font-size: 0.9rem;">Date of Interview</h6>
                            <p class="mb-0 fw-bold" style="font-size: 1rem;">{{ $feedback->interview_date ?? 'Not Provided' }}</p>
                        </div>
                    </div>

                    <!-- OTHER INFORMATION (Now Below Date of Interview) -->
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <img src="{{ asset('images/CSD_ICON.svg') }}" alt="Icon" class="rounded-circle me-2" width="30">
                        <div>
                            <h6 class="mb-1 text-uppercase text-muted" style="font-size: 0.9rem;">Other Information of the Client</h6>
                            <p class="mb-0 fw-bold" style="font-size: 1rem;">{{ $feedback->client_info ?? 'No additional information' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

    
    @include('class.insights')
    @include('class.contact')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>