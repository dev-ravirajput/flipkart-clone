@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<style>
    td{
        vertical-align: middle;
    }
</style>
@section('content')
<section class="mt-2">
    <h2 class="">Products</h2>
    <div class="container card p-4">
        <div class="text-end">
        <a href="{{ route('admin.products.add') }}" class="btn btn-primary">Add Product</a>
        </div>
        <div class="row mt-2">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Sub Category</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center"><img src="{{ asset('storage/'.$product->featured_image) }}" alt="" width="50" height="50" style="border-radius: 5px;"></td>
                    <td class="text-center">{{ $product->name }}</td>
                    @php
                     $brand = getBrands($product->brand_id);
                     $subcategory = getSubcategory($product->subcategory_id);
                     $category = getCategory($product->category_id);
                     @endphp
                    <td class="text-center">{{ $brand ? $brand->name : 'Not Found' }}</td>
                    <td class="text-center">{{ $subcategory->name }}</td>
                    <td class="text-center">{{ $category->name }}</td>
                    <td class="text-center">
                        @if($product->status == 1)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a title="Update Product" href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a title="Delete Product" href="javascript:void(0)" onclick="confirmDelete({{ $product->id }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form dynamically and submit it
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.products.delete", ":id") }}'.replace(':id', id);

            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            var deleteMethod = document.createElement('input');
            deleteMethod.type = 'hidden';
            deleteMethod.name = '_method';
            deleteMethod.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(deleteMethod);

            document.body.appendChild(form);
            form.submit(); // Submit the form to perform the delete
        }
    });
}
</script>
@endsection