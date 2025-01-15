@extends('layouts.frontend')

@section('content')
<style>
    .slider img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .cards {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: space-between;
        overflow: auto;
    }
    .card-item {
        width: 30%;
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
    }
    .card-item img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        margin-bottom: 10px;
    }
    .lines p {
        margin: 5px 0;
    }
    .viewall-btn{
        width: auto;
        margin-left: auto;
    }
    .carousel-indicators button {
    background-color: #000; /* Black dots */
}

.carousel-indicators .active {
    background-color: #fff; /* Active dot in white */
}

.carousel-control-prev-icon, .carousel-control-next-icon {
    background-color: #000; /* Black arrows */
}

</style>
<div class="container">
    <!-- Slider Section -->
    <div id="promotionSlider" class="carousel slide" data-bs-ride="carousel">
    <!-- Carousel Indicators (dots) -->
    <div class="carousel-indicators">
        @foreach($promotions as $index => $slider)
            <button type="button" data-bs-target="#promotionSlider" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>

    <!-- Carousel Inner (slides) -->
    <div class="carousel-inner">
        @foreach($promotions as $index => $slider)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $slider->images) }}" alt="Promotional Banner" class="img-fluid d-block w-100" />
            </div>
        @endforeach
    </div>

    <!-- Carousel Controls (arrows) -->
    <button class="carousel-control-prev" type="button" data-bs-target="#promotionSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#promotionSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

    
    <!-- Shopping Section -->
    <section>
        <h3 class="my-1">All Categories  <a class="btn btn-primary viewall-btn">VIEW ALL</a></h3>
        <div class="cards">
            @foreach ($categories as $item)
                <div class="card-item">
                    <img src="{{ asset('storage/'. $item->image) }}" alt="Product Image" />
                    <div class="lines">
                        <p class="text-center">Verified</p>
                        <p class="text-center">{{ $item->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Discount Section -->
    <section>
        <h3 class="my-1">Maximum Off Sale % <a class="btn btn-primary viewall-btn">VIEW ALL</a></h3>
        <div class="cards">
            @foreach ($products as $item)
                <div class="card-item">
                    <img src="{{ asset('storage/'. $item->featured_image) }}" alt="Product Image" />
                    <div class="lines">
                        <p class="text-center">Verified</p>
                        <p class="text-center">{{ $item->name }}</p>
                        <p class="text-center">Min {{ $item['discount_percentage'] }}%</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
