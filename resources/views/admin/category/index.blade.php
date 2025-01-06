@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@section('content')
<section class="mt-2">
    <h2 class="">Categories</h2>
    <div class="container card p-4">
        <div class="text-end">
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Add Category</a>
        </div>
        <div class="row mt-2">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Slug</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/'.$category->image) }}" alt="" width="50" height="50" style="border-radius: 5px;">
                        </td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">{{ $category->slug }}</td>
                        <td class="text-center">
                            @if($category->status == 1)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                        <a title="Update Catecory" href="{{ route('admin.edit.category', $category->id) }}" class="btn btn-secondary"><i class="fa-regular fa-pen-to-square"></i></a>    
                        <a title="Delete Category" href="javascript:void(0);" class="btn btn-danger" onclick="confirmDelete({{ $category->id }})"><i class="fa-solid fa-trash"></i></a>
                        <td>
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
            form.action = '{{ route("admin.delete.category", ":id") }}'.replace(':id', id);

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