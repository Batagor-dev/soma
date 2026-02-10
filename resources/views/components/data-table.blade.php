@props(['id', 'ajaxUrl', 'sub_title'])

@push('styles')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
@endpush

<div class="card">
    <h5 class="card-header text-center text-md-start pb-md-0">{{ $sub_title }}</h5>
    <div class="card-datatable text-nowrap">
        <table  class="table table-bordered table-responsive" 
                id="{{ $id }}"
                data-link="{{ $ajaxUrl }}">
        </table>
    </div>
</div>

@once
@push('scripts')
<script src="{{ asset('assets/js/datatable/data-table.js') }}"></script>
@endpush
@endonce
