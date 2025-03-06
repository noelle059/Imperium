@if(isset($images) && $images->count() > 0)
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($images as $index => $image)
                <button type="button" data-bs-target="#carouselExampleIndicators" 
                        data-bs-slide-to="{{ $index }}" 
                        @if($index == 0) class="active" @endif 
                        aria-label="Slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner c-img">
            @foreach($images as $index => $image)
                <div class="carousel-item @if($index == 0) active @endif">
                    <img src="{{ asset('images/' . $image->filename) }}" class="d-block w-100" alt="Slide {{ $index + 1 }}">
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@else
    <p>No images available.</p>
@endif
