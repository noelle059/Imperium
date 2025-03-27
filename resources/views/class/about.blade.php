<div id="about" class="about-section d-flex flex-wrap">
<div class="about-image flex-shrink-0">
        @if(isset($aboutUs) && $aboutUs->image)
            <img src="{{ asset('storage/' . $aboutUs->image) }}" alt="About Image" class="img-fluid about-img">
        @else
            <img src="{{ asset('images/GLOBE_BACKGROUND.svg') }}" alt="Default About Image" class="img-fluid about-img">
        @endif
    </div>

    <div class="about-text">
    <h1>{{ $aboutUs->title ?? 'THE FUTURE OF' }}</h1>
        <h1><span class="text-success">{{ $aboutUs->subtitle ?? 'CLASSROOM AUTOMATION' }}</span></h1>
        <p class="lead">{{ $aboutUs->abstract ?? 'Empowering educators and institutions with an intelligent, energy-efficient system for seamless classroom management and security.' }}</p>
        <button class="read-more" data-bs-toggle="modal" data-bs-target="#insightsModal">READ MORE</button>


        <!-- Featured In -->
        <div class="featured mt-4">
            <h4 class="fw-bold">FEATURED IN:</h4>
            <div class="d-flex justify-content-center gap-3">
                @if(isset($aboutUs) && $aboutUs->featured_1)
                    <img src="{{ asset('storage/' . $aboutUs->featured_1) }}" alt="Partner 1" class="featured-img">
                @endif
                @if(isset($aboutUs) && $aboutUs->featured_2)
                    <img src="{{ asset('storage/' . $aboutUs->featured_2) }}" alt="Partner 2" class="featured-img">
                @endif
                @if(isset($aboutUs) && $aboutUs->featured_3)
                    <img src="{{ asset('storage/' . $aboutUs->featured_3) }}" alt="Partner 3" class="featured-img">
                @endif
            </div>
            </div>
    </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade about-modal" id="insightsModal" tabindex="-1" aria-labelledby="insightsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content custom-modal">

            <div class="modal-header">
                <img src="{{ asset('images/IMPERIUM_LOGO.svg') }}" alt="Imperium Logo" class="modal-logo">
                <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="content-box">
                    <h2 class="modal-title">{{ $aboutUs->modal_title ?? 'An IoT-Based Energy Conservation Smart Classroom System' }}</h2>
                    <p class="modal-subtitle"><em>{{ $aboutUs->modal_subtitle ?? 'Intelligent Automation & Soft Computing' }}</em></p>
                    <p class="modal-subtitle"><em>DOI: {{ $aboutUs->modal_doi ?? '10.32604/iasc.2023.032250' }}</em></p>
                    <p class="modal-meta"><em>{{ $aboutUs->modal_meta ?? 'Article' }}</em></p>

                    <p class="modal-abstract">
                        <strong>Abstract:</strong>
                        <span id="abstract-short">
                            {{ $aboutUs->modal_abstract ?? 'Default abstract text...' }}
                        </span>
                    </p>

                    <p class="modal-read">
                        <strong>Read full study on</strong><br>
                        <a href="{{ Str::startsWith($aboutUs->modal_article_link, ['http://', 'https://']) ? $aboutUs->modal_article_link : 'https://' . $aboutUs->modal_article_link }}" target="_blank" class="modal-link">
                            {{ $aboutUs->modal_article_link ?? 'No link available' }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
