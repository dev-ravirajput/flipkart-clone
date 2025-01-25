@extends('layouts.frontend')
@section('content')
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

nav .navbar-header a {
    font-family: 'Raleway', sans-serif;
    letter-spacing: 1px;
    color: #fff;
}

nav .navbar-header button .fa {
    color: #fff;
    border: 1px solid #fff;
    border-radius: 5px;
    padding: 4px 10px;
    font-size: 1.5em;
    position: relative;
}

.glyphicon-search {
    color: #2874f0;
}

form {
    margin-top: 10px;
}

.menu {
    padding: 10px 0;
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.menu .btn {
    text-transform: uppercase;
    font-weight: bold;
    background-color: #fff;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    width: 100%;
}

section {
    padding: 2em 0;
}

.thumbnail {
    position: relative;
    overflow: hidden;
    text-align: center;
}

.thumbnail img {
    max-width: 100%;
    height: auto;
}

.thumbnail .caption {
    padding: 10px;
}

.buttons .btn {
    margin: 5px 5px 10px;
    width: 45%;
    font-size: 1em;
}

.desc h4 {
    font-size: 1.8em;
    font-weight: bold;
    margin-bottom: 15px;
}

.desc h3 {
    font-size: 2em;
    color: #ff5722;
    margin: 15px 0;
}

.desc .label-success {
    font-size: 1em;
}

.desc .breadcrumb {
    padding-left: 0;
    margin-top: 15px;
}

.desc .row button {
    margin: 10px 5px;
}

.desc ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.desc ul li {
    font-size: 1em;
    margin-bottom: 5px;
}

@media (max-width: 768px) {
    .desc h3 {
        font-size: 1.5em;
    }

    .desc h4 {
        font-size: 1.5em;
    }

    .menu .col-sm-2 {
        margin-bottom: 15px;
    }
}
</style>

<div class="menu container-fluid text-center hidden-xs">
    <div class="row">
        @foreach($categories as $category)
        <div class="col-sm-2">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenu{{ $loop->index }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {{ $category->name }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $loop->index }}">
                <li><a href="#">Footwear</a></li>
            </ul>
        </div>
        @endforeach
    </div>
</div>

<section>
    <div class="container">
        <div class="row">
            <!-- Product Picture -->
            <div class="col-md-5">
                <div class="thumbnail">
                    <img src="{{ asset('storage/'. $product->featured_image) }}" alt="Product Image">
                    <div class="caption">
                        <div class="row buttons">
                            <button class="btn btn-warning">
                                <span class="glyphicon glyphicon-shopping-cart"></span> ADD TO CART
                            </button>
                            <button class="btn btn-danger">
                                <i class="fa fa-bolt"></i> BUY NOW
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="col-md-7 desc">
                <h4>{{ $product->name }}</h4>

                <div class="row">
                    <div class="col-md-3">
                        <span class="label label-success">4.6</span>
                        <span class="rating-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    </div>
                    <div class="col-md-6">
                        <strong>2,421 Ratings & Reviews</strong>
                    </div>
                </div>

                <div class="price mb-2 mt-2">
                    <del>Rs. {{ $product->price }}</del>
                    <span>Rs. {{ $product->discount_price }}</span>
                    <small>({{ $product->discount_percentage }}% off)</small>
                </div>

                <h5>
                    <span class="glyphicon glyphicon-calendar"></span> EMIs from <strong>Rs 3,070/month</strong>
                    <a href="#">View Plans <i class="fa fa-chevron-right"></i></a>
                </h5>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <strong>Color</strong><br><br>
                        <button class="btn btn-outline-primary">
                            <img src="https://cdn.mobilephonesdirect.co.uk/images/handsets/480/apple/apple-iphone-x-silver.png" alt="Silver" class="img-fluid">
                        </button>
                        <button class="btn btn-outline-primary">
                            <img src="https://cdn.mobilephonesdirect.co.uk/images/handsets/apple/apple-iphone-x-space-grey.png" alt="Space Grey" class="img-fluid">
                        </button>
                    </div>

                    <div class="col-md-6">
                        <strong>Storage</strong><br><br>
                        <button class="btn btn-outline-primary">64GB</button>
                        <button class="btn btn-outline-primary">256GB</button>
                    </div>
                </div>

                <div id="highlights" class="mt-4">
                    <strong>Highlights</strong>
                    <ul>
                        <li>64GB ROM</li>
                        <li>5.8 inch Super Retina HD Display</li>
                        <li>12MP + 12MP Dual Rear Camera | 7MP Front Camera</li>
                        <li>lithium-ion Battery</li>
                        <li>A11 Bionic Chip with 64-bit Architecture, Neural Engine, Embedded M11 Motion Co-processor</li>
                    </ul>
                </div>

                <div class="product-description mt-5">
                    <h3>PRODUCT DESCRIPTION</h3>
                    <p>{!! $product->description !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
