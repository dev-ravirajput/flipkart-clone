@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<style>
    .list-group-item.active {
        background: rgb(6, 165, 193) !important;
    }

    .profile-img {
        width: 100px !important;
        height: 100px !important;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 4% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 70%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out;
    }

    .close {
        float: right;
        font-size: 30px;
    }

    @media (max-width: 768px) {
        .main-body {
            flex-direction: column;
        }

        .modal-content {
            padding: 10px 0 !important;
            width: 95% !important;
        }
    }
</style>
@endsection

@section('content')
<body>
    <section class="my-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div>
                                @if(Auth::user()->profilePic)
                                    <img src="{{ asset('storage/' . Auth::user()->profilePic) }}" alt="Profile Picture" class="profile-img" height="100" width="100">
                                @else
                                    <img src="{{ asset('img/man.png') }}" alt="Default Profile Picture" class="profile-img" height="100" width="100">
                                @endif
                            </div>
                            <div class="mt-3">
                                <h4>{{ $user->name }}</h4>
                                <p class="text-secondary mb-1">{{ $user->email }}</p>
                                <p class="text-secondary mb-1" style="text-transform: capitalize;">{{ $user->role }}</p>
                            </div>
                            <div class="list-group mt-4">
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action active" onclick="showProfileDetails()">Profile Information</a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="showEditForm()">Change Details</a>
                                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Profile Details -->
                    <div id="profileDetails" class="card">
                        <div class="card-body">
                            <h5>Profile Information</h5>
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email Address:</strong> {{ $user->email }}</p>
                            <p style="text-transform: capitalize;"><strong>Role:</strong> {{ $user->role }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                            <p><strong>Location:</strong> {{ $user->address }}</p>
                            <p><strong>Country:</strong> {{ $user->country }}</p>
                        </div>
                    </div>

                    <!-- Update Form -->
                    <div id="updateForm" class="card d-none">
                        <div class="card-body">
                            <h5>Update Details</h5>
                            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone:</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="location">Location:</label>
                                            <input type="text" class="form-control" id="location" name="address" value="{{ $user->location }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country:</label>
                                            <input type="text" class="form-control" id="country" name="country" value="{{ $user->country }}" placeholder="Type to search...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profilePic">Profile Picture:</label>
                                            <input type="file" class="form-control" id="profilePic" name="profilePic">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPpH4FGQaj_JIJOViHAeHGAjl7RDeW8OQ&libraries=places"></script>

    <!-- JavaScript -->
    <script>
        function showProfileDetails() {
            document.getElementById('profileDetails').classList.remove('d-none');
            document.getElementById('updateForm').classList.add('d-none');
        }

        function showEditForm() {
            document.getElementById('updateForm').classList.remove('d-none');
            document.getElementById('profileDetails').classList.add('d-none');
        }

        function initializeAutocomplete() {
        // Target the input field
        const input = document.getElementById('country');
        // Set autocomplete options for countries only
        const options = {
            types: ['(regions)'], // Focus on regions (countries, states)
        };
        // Initialize Google Places Autocomplete
        const autocomplete = new google.maps.places.Autocomplete(input, options);

        // Optional: Handle the event when a suggestion is selected
        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
        });
    }

        // Load Google Maps API and initialize autocomplete
        window.onload = function() {
            initializeAutocomplete();
        };
    </script>
</body>
@endsection
