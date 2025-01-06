@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@section('content')
<section>
    <div class="container">
        <h2 class="mt-2">Add Brand</h2>
        <div class="card p-3 mt-2">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Category</label>
                           <select name="category_id" class="form-control">
                            <option selected disabled>Choose Category</option>
                            @foreach($subcategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Logo</label>
                            <input type="file" name="image" id="image" class="form-control" onchange="previewImage()">
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image-preview">Logo Preview</label><br>
                            <img id="image-preview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 150px; display: none; border-radius: 10px; border
                            : 1px solid #ddd;">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function previewImage() {
        const file = document.getElementById('image').files[0];
        const preview = document.getElementById('image-preview');
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the preview
        }
        
        if (file) {
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    }
</script>
@endsection
