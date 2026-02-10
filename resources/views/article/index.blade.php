@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Articles';
@endphp

@extends('layout.backend.main', [
    'title' => $sub_title . ' | ' . config('app.name'),
    'sub_title' => $sub_title
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ Breadcrumbs::render(Request::route()->getName()) }}

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $sub_title }}</h5>
            @can('Article Create')
                <a href="{{ route('article.create') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line me-1"></i>Create New
                </a>
            @endcan
        </div>

        <div class="card-datatable p-3">
            {!! $dataTable->table(['class' => 'table table-bordered table-hover align-middle mb-0']) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif

    {{-- Render DataTable --}}
    {!! $dataTable->scripts() !!}

    <script>
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    </script>
@endpush
