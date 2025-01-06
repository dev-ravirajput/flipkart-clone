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
                        <th class="text-center">Slug</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
  
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
            form.action = '{{ route("admin.subcategory.delete", ":id") }}'.replace(':id', id);

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