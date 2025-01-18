@extends('layouts.frontend')
@section('content')
<style>
    /* Slider Styling */
    .slider img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 5px;
    }

    /* Card Styling */
    .card-item {
        border: 1px solid #ccc;
        padding: 15px;
        text-align: center;
        border-radius: 10px;
        margin-bottom: 20px;
        transition: transform 0.2s, box-shadow 0.2s;
        background: #f8f9fa;
    }

    .card-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .card-item img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .lines p {
        margin: 5px 0;
        font-size: 14px;
        font-weight: 500;
        color: #555;
    }

    /* Carousel Buttons */
    .carousel-indicators button {
        background-color: #6c757d;
    }

    .carousel-indicators .active {
        background-color: #fff;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        padding: 10px;
    }

    /* Section Titles */
    h3 {
        font-size: 22px;
        font-weight: bold;
        color: #343a40;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    h3 .viewall-btn {
        font-size: 14px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        background-color: #2874f0;
        color: #fff;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    h3 .viewall-btn:hover {
        background-color: #0d6efd;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 1200px) {
        .slider img {
            height: 250px;
        }

        .card-item img {
            height: 200px;
        }
    }

    @media (max-width: 992px) {
        h3 {
            font-size: 20px;
        }

        .viewall-btn {
            font-size: 12px;
        }
    }

    @media (max-width: 768px) {
        .slider img {
            height: 200px;
        }

        .card-item {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 576px) {
        .card-item img {
            height: 150px;
        }

        .slider img {
            height: 180px;
        }
    }
</style>

<div class="container-class">
    <!-- Slider Section -->
    <div id="promotionSlider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($promotions as $index => $slider)
                <button type="button" data-bs-target="#promotionSlider" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($promotions as $index => $slider)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $slider->images) }}" alt="Promotional Banner" class="img-fluid d-block w-100" />
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#promotionSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#promotionSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <section class="mt-4">
        <h3>All Categories <a class="btn btn-primary viewall-btn" href="#">VIEW ALL</a></h3>
        <div class="row">
            @foreach ($categories as $item)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card-item">
                        <img src="{{ asset('storage/'. $item->image) }}" alt="Category Image" />
                        <div class="lines">
                            <p class="text-center">Verified</p>
                            <p class="text-center">{{ $item->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Discount Section -->
    <section class="mt-4">
        <h3>Maximum Off Sale % <a class="btn btn-primary viewall-btn" href="#">VIEW ALL</a></h3>
        <div class="row">
            @foreach ($products as $item)
                <div class="col-lg-4 col-md-6 col-sm-12" onclick="goToDetailsPage('{{ route('product.details', $item->slug) }}')">
                    <div class="card-item">
                        <img src="{{ asset('storage/'. $item->featured_image) }}" alt="Product Image" />
                        <div class="lines">
                            <p class="text-center">Verified</p>
                            <p class="text-center">{{ $item->name }}</p>
                            <p class="text-center">Min {{ $item->discount_percentage }}% OFF</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
<script>
    function goToDetailsPage(url) {
        // Redirect to the details page using the provided URL
        window.location.href = url;
    }
</script>


@endsection
