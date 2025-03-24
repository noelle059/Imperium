<footer id="contact" class="new-footer">
    <div class="container">
        <div class="footer-content">

            <div class="footer-left">
                <img src="{{ asset($footerContent->logo ?? 'images/default-logo.svg') }}" alt="Imperium Logo" class="footer-logo">
                <p class="footer-desc">
                    {{ $footerContent->description ?? 'Default footer description' }}
                </p>
            </div>

            <div class="footer-middle">
                <h5 style="text-decoration: underline; text-decoration-color: green; text-underline-offset: 5px;">Featured in:</h5>
                <div class="featured-logos">
                    @if($footerContent->featured_1)
                        <img src="{{ asset('storage/' . $footerContent->featured_1) }}" alt="Featured 1">
                    @endif
                    @if($footerContent->featured_2)
                        <img src="{{ asset('storage/' . $footerContent->featured_2) }}" alt="Featured 2">
                    @endif
                    @if($footerContent->featured_3)
                        <img src="{{ asset('storage/' . $footerContent->featured_3) }}" alt="Featured 3">
                    @endif
                </div>
            </div>

            <div class="footer-address">
                <h5 style="text-decoration: underline; text-decoration-color: green; text-underline-offset: 5px;">Address:</h5>
                <p style="padding-bottom: 5px;">{{ $footerContent->address ?? 'Default address' }}</p>

                <h5 style="text-decoration: underline; text-decoration-color: green; text-underline-offset: 5px;">Email:</h5>
                <p>
                    <a href="mailto:{{ $email->address ?? 'imperiumsystem001@gmail.com' }}"
                    style="color: white; text-decoration: none;"
                    onmouseover="this.style.color='green'"
                    onmouseout="this.style.color='white'">
                    {{ $email->address ?? 'imperiumsystem001@gmail.com' }}
                    </a>
                </p>

                <h5 style="margin-top: 5px; text-decoration: underline; text-decoration-color: green; text-underline-offset: 5px;">Contact:</h5>
                <p>{{ $email->contact ?? '0905 334 3426' }}</p>
            </div>

            <div class="footer-right">
                <h5 style="text-decoration: underline; text-decoration-color: green; text-underline-offset: 5px;">Location:</h5>
                <iframe src="{{ $footerContent->map_url ?? 'https://www.google.com/maps' }}" loading="lazy"></iframe>
            </div>
        </div>

        <div class="footer-bottom">
            2025 @ Third Year College - University of Caloocan City - Imperium.
        </div>
    </div>
</footer>
