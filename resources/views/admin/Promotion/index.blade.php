@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@section('content')
<section>
    <div class="container">
        <h2 class="mt-2">Add Banner For Promotion</h2>
        <div class="card p-3 mt-2">
            <form id="banner-form" action="{{ route('admin.promotion.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Drag and Drop Area for Multiple Images -->
                    <div class="form-group mt-3">
                        <label for="images">Upload Banners (Drag and drop images here)</label>
                        <div id="drop-area" class="border p-4 text-center">
                            <p>Drag & Drop your images here or click to select.</p>
                            <input type="file" name="images[]" id="images" accept="image/*" multiple style="display: none;" onchange="previewImages()">
                        </div>
                        <div id="image-previews" class="mt-3"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary" id="submit-button">Add Banners</button>
                    </div>
                </div>
            </form>
            
            @if($promotions)
                <div class="mt-4">
                    <h3>Uploaded Images:</h3>
                    <div id="uploaded-images">
                        @foreach($promotions as $image)
                            <div class="img-wrapper">
                                <img src="{{ asset('storage/' . $image->images) }}" class="img-thumbnail" width="100">
                                <form method="POST" action="{{ route('admin.promotion.delete', $image->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    // Make the drop area clickable
    document.getElementById('drop-area').addEventListener('click', function() {
        document.getElementById('images').click();
    });

    // Handle drag and drop events
    const dropArea = document.getElementById('drop-area');
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropArea.style.backgroundColor = '#f0f0f0'; // Change background on hover
    });
    dropArea.addEventListener('dragleave', function() {
        dropArea.style.backgroundColor = ''; // Reset background
    });
    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.style.backgroundColor = ''; // Reset background
        const files = e.dataTransfer.files;
        document.getElementById('images').files = files; // Set files in input
        previewImages(); // Preview the images
    });

    // Preview the uploaded images
    function previewImages() {
        const files = document.getElementById('images').files;
        const previewContainer = document.getElementById('image-previews');
        previewContainer.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('img-wrapper');
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'm-2');
                img.style.width = '100px'; // Set size of preview image
                
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'X';
                deleteButton.classList.add('btn', 'btn-danger', 'delete-btn', 'm-2');
                deleteButton.onclick = function() {
                    deleteImage(e.target.result);
                };
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(deleteButton);
                previewContainer.appendChild(imgWrapper);
            }
            reader.readAsDataURL(file);
        });
    }

    // Delete image from preview and confirm deletion
    function deleteImage(imageSrc) {
        const confirmation = confirm('Are you sure you want to delete this image?');
        if (confirmation) {
            const previewContainer = document.getElementById('image-previews');
            const images = previewContainer.querySelectorAll('img');
            images.forEach(function(image) {
                if (image.src === imageSrc) {
                    image.parentElement.remove(); // Remove the image from preview
                }
            });
        }
    }
</script>
@endsection
