@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@section('content')
<section>
    <div class="container">
        <h2 class="mt-2">Update Sub category</h2>
        <div class="card p-3 mt-2">
            <form action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Category</label>
                           <select name="category_id" class="form-control">
                            <option selected disabled>Select an option</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Sub category Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $subcategory->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="4">{{ $subcategory->description }}</textarea>
                        </div>
                    </div>

                     <!-- Image Upload Field -->
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control" onchange="previewImage()">
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image-preview">Image Preview</label><br>
                            <!-- Show existing image if available -->
                            @if($category->image)
                                <img id="image-preview" src="{{ asset('storage/' . $subcategory->image) }}" alt="Existing Image" style="max-width: 100%; max-height: 150px; display: block; border-radius: 10px; border: 1px solid #ddd;">
                            @else
                                <img id="image-preview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 150px; display: none; border-radius: 10px; border: 1px solid #ddd;">
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update Sub Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Function to Preview New Image
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
