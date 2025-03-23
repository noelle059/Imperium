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
                <h5>Featured in</h5>
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
                <h5>Address</h5>
                <p style="padding-bottom: 5px;">{{ $footerContent->address ?? 'Default address' }}</p>

                <h5>Email</h5>
                <p style="padding-bottom: 5px;">{{ $email->address ?? 'imperiumsystem001@gmail.com' }}</p>

                <h5>Contact</h5>
                <p style="padding-bottom: 5px;">{{ $email->contact ?? '0905 334 3426' }}</p>
            </div>

            <div class="footer-right">
                <h5>Location</h5>
                <iframe src="{{ $footerContent->map_url ?? 'https://www.google.com/maps' }}" loading="lazy"></iframe>
            </div>
        </div>

        <div class="footer-bottom">
            2025 @ Third Year College - University of Caloocan City - Imperium.
        </div>
    </div>
</footer>
