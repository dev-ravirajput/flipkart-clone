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
    <h2 class="">Brands</h2>
    <div class="container card p-4">
        <div class="text-end">
        <a href="{{ route('admin.brands.add') }}" class="btn btn-primary">Add Brand</a>
        </div>
        <div class="row mt-2">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Subcategory</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                       @foreach($brands as $brand)
                       <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/'.$brand->logo) }}" alt="" width="40" height="40" style="border-radius: 5px;">
                        </td>
                        <td class="text-center">{{ $brand->name }}</td>
                        @php
                         $subcategory = getSubcategory($brand->subcategory_id);
                         $category = getCategory($subcategory->category_id);
                         @endphp
                        <td class="text-center">{{ $subcategory->name }}</td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">
                            @if($brand->status == 1)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a title="Update Brand" href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-secondary"><i class="fa-regular fa-pen-to-square"></i></a>
                            <a title="Delete Brand" href="javascript:void(0)" onclick="confirmDelete({{ $brand->id }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
            form.action = '{{ route("admin.brands.delete", ":id") }}'.replace(':id', id);

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