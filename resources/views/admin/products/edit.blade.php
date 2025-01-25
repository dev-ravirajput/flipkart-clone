@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link href="{{ asset('summernote/summernote.css') }}" rel="stylesheet">
<style>
    label {
        margin-top: 10px;
    }
    textarea{
        height: 749px;
    }
</style>
@section('content')
<section>
    <div class="container">
        <h2 class="mt-2">Edit Product</h2>
        <div class="card p-3 mt-2">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Product Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option selected disabled>Choose Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subcategory_id">Product Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                                <option selected disabled>Choose Subcategory</option>
                            </select>
                            @error('subcategory_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brand">Product Brand</label>
                            <select name="brand_id" id="brand" class="form-control">
                                <option selected disabled>Choose Brand</option>
                            </select>
                            @error('brand')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select Status</option>
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Product Actual Price</label>
                            <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" oninput="calculateDiscount()">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="percentage">Discount Percentage</label>
                            <input type="number" name="discount_percentage" class="form-control" id="percentage" value="{{ old('percentage', $product->discount_percentage) }}" oninput="calculateDiscount()">
                            @error('percentage')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount_price">Product Discount Price</label>
                            <input type="number" name="discount_price" class="form-control" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" readonly>
                            @error('discount_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Featured Image</label>
                            <input type="file" name="featured_image" id="image" class="form-control" onchange="previewImage()">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image-preview">Featured Image Preview</label><br>
                            <img id="image-preview" src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : '#' }}" alt="Image Preview" style="max-width: 100%; max-height: 150px; display: {{ $product->featured_image ? 'block' : 'none' }}; border-radius: 10px; border: 1px solid #ddd;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="imageGallery">Image Gallery</label>
                            <input type="file" name="images[]" id="imageGallery" class="form-control" onchange="previewGalleryImages()" multiple>
                            @error('images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gallery-image-preview">Gallery Image Preview</label>
                            <div id="gallery-image-preview" style="display: flex; gap: 10px; flex-wrap: wrap; border: 1px solid #ddd; padding: 10px; border-radius: 10px;">
                                <!-- Thumbnails with remove buttons will appear here -->
                                @foreach($product->gallery_images as $image)
                                    <div style="position: relative; display: inline-block;">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" style="max-width: 100px; max-height: 100px; border-radius: 10px; border: 1px solid #ddd; object-fit: cover; margin-right: 10px;">
                                        <button type="button" onclick="removeImage('{{ $image }}')" style="position: absolute; top: 5px; right: 5px; background: #ff4d4d; color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center;">×</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('summernote/summernote.js') }}"></script>

<script>
    // Prefill subcategories and brands when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        const categoryId = document.getElementById('category_id').value;
        const subcategoryId = '{{ $product->subcategory_id }}';  // Use the product's current subcategory_id

        // Prefill Subcategories
        if (categoryId) {
            fetch(`/admin/products/get-subcategories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    const subcategorySelect = document.getElementById('subcategory_id');
                    data.forEach(subcategory => {
                        subcategorySelect.innerHTML += `<option value="${subcategory.id}" ${subcategory.id == subcategoryId ? 'selected' : ''}>${subcategory.name}</option>`;
                    });
                    // After subcategories are loaded, prefill brands for the selected subcategory
                    prefillBrands(subcategoryId);
                });
        }

        // Function to prefill brands based on the selected subcategory
        function prefillBrands(subcategoryId) {
            const brandId = '{{ $product->brand_id }}';  // Use the product's current brand_id
            if (subcategoryId) {
                fetch(`/admin/products/get-brands/${subcategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        const brandSelect = document.getElementById('brand');
                        data.forEach(brand => {
                            brandSelect.innerHTML += `<option value="${brand.id}" ${brand.id == brandId ? 'selected' : ''}>${brand.name}</option>`;
                        });
                    });
            }
        }
    });
</script>

<script>
    function calculateDiscount() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const percentage = parseFloat(document.getElementById('percentage').value) || 0;

        if (price > 0 && percentage >= 0) {
            const discountPrice = price - (price * (percentage / 100));
            document.getElementById('discount_price').value = discountPrice; 
        } else {
            document.getElementById('discount_price').value = ''; // Clear the field if inputs are invalid
        }
    }
</script>

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
<script>
    let selectedFiles = []; // Array to hold selected files

    document.getElementById('imageGallery').addEventListener('change', function () {
        const previewContainer = document.getElementById('gallery-image-preview');
        previewContainer.innerHTML = ''; // Clear previous previews

        selectedFiles = Array.from(this.files); // Store selected files in an array

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                // Create a container for the image and close button
                const imageContainer = document.createElement('div');
                imageContainer.style.position = 'relative';
                imageContainer.style.display = 'inline-block';

                // Create image element
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Gallery Image Preview';
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                img.style.borderRadius = '10px';
                img.style.border = '1px solid #ddd';
                img.style.objectFit = 'cover';
                img.style.marginRight = '10px';

                // Create remove button
                const removeButton = document.createElement('button');
                removeButton.textContent = '×';
                removeButton.style.position = 'absolute';
                removeButton.style.top = '5px';
                removeButton.style.right = '5px';
                removeButton.style.background = '#ff4d4d';
                removeButton.style.color = '#fff';
                removeButton.style.border = 'none';
                removeButton.style.borderRadius = '50%';
                removeButton.style.width = '20px';
                removeButton.style.height = '20px';
                removeButton.style.cursor = 'pointer';
                removeButton.style.display = 'flex';
                removeButton.style.alignItems = 'center';
                removeButton.style.justifyContent = 'center';
                removeButton.title = 'Remove image';

                // Add click event to remove image
                removeButton.onclick = function () {
                    selectedFiles.splice(index, 1); // Remove file from the array
                    imageContainer.remove(); // Remove the container
                    updateFileInput(); // Update the input field's files
                };

                // Append image and button to the container
                imageContainer.appendChild(img);
                imageContainer.appendChild(removeButton);

                // Append the container to the preview area
                previewContainer.appendChild(imageContainer);
            };

            reader.readAsDataURL(file); // Read the file
        });
    });

    // Update the file input field with the remaining files
    function updateFileInput() {
        const dataTransfer = new DataTransfer(); // Create a new DataTransfer object
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file); // Add each remaining file to the DataTransfer object
        });
        document.getElementById('imageGallery').files = dataTransfer.files; // Update the file input field
    }

    // Function to handle removing existing images (this can be enhanced with AJAX if needed)
    function removeImage(imagePath) {
        // Optionally, you can send a request to the server to remove the image from the database/storage
        // Example: fetch('/admin/products/remove-image', { method: 'POST', body: { image: imagePath } })

        const previewContainer = document.getElementById('gallery-image-preview');
        const images = previewContainer.getElementsByTagName('img');
        
        // Find the image that matches the path and remove it from the preview
        for (let img of images) {
            if (img.src.includes(imagePath)) {
                img.closest('div').remove(); // Remove the parent container of the image
                break;
            }
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#description').summernote();
    });
  </script>
@endsection
