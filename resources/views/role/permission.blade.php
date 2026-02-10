@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
    $breadcrumb_parent = Breadcrumbs::generate(Request::route()->getName(), $role)
                        ->where('title','!=',$breadcrumb->title)->last();
@endphp

@extends('layout.backend.main', [
    'title' => 'User | '.config('app.name'),
    'sub_title' => $sub_title
])

@push('styles')
    
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{ Breadcrumbs::render(Request::route()->getName(), $role) }}

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Hak Akses : {{ $role->name }}</h5>
        </div>

        <form id="formPermission" method="POST" action="{{ $action }}">
            @csrf
            {{-- field tersembunyi berisi id hak akses yg dicentang --}}
            <input type="hidden" name="permission" id="checkedPermissions">

            <div class="card-body">
                <div id="jstree-checkbox"></div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('role') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const theme = $('html').attr('data-bs-theme') === 'dark' ? 'default-dark' : 'default';

    /* ---------- 1. Bangun data jsTree ---------- */
    let jsTreeData = [];

    /* 1.a Root: All Permissions (akan jadi parent semua) */
    let allChildren = [];

    /* 1.b Hak akses tanpa grup → jadi anak “All Permissions” */
    @foreach($permissions as $p)
        allChildren.push({
            id    : '{{ $p->id }}',
            text  : '{{ $p->name }}',
            type  : 'file',
            state : { selected: {{ $role->permissions->contains($p->id) ? 'true' : 'false' }} }
        });
    @endforeach

    /* 1.c Hak akses ber-grup → tiap grup jadi anak “All Permissions” */
    @foreach($permission_groups as $grp)
        (function(){
            var children = [];
            @foreach($grp->permissions as $perm)
                children.push({
                    id    : '{{ $perm->id }}',
                    text  : '{{ $perm->name }}',
                    type  : 'file',
                    state : { selected: {{ $role->permissions->contains($perm->id) ? 'true' : 'false' }} }
                });
            @endforeach
            allChildren.push({
                text : '{{ $grp->name }}',
                type : 'folder',
                state: { opened: true },
                children: children
            });
        })();
    @endforeach

    /* Masukkan node “All Permissions” */
    jsTreeData.push({
        id   : 'all',
        text : 'All Permissions',
        type : 'all',
        state: { opened: true },
        children: allChildren
    });

    /* ---------- 2. Inisialisasi jsTree ---------- */
    $('#jstree-checkbox').jstree({
        core : {
            themes : { name: theme },
            data   : jsTreeData
        },
        plugins : ['types', 'checkbox', 'wholerow'],
        types   : {
            default : { icon: 'icon-base ri ri-folder-3-line icon-18px bg-warning' },
            folder  : { icon: 'icon-base ri ri-folder-3-line icon-18px bg-warning' },
            file    : { icon: 'icon-base ri ri-file-text-line icon-18px bg-info' },
            all     : { icon: 'icon-base ri ri-shield-check-line icon-18px bg-primary' }
        }
    });

    /* ---------- 3. Centang / hapus centang semua ---------- */
    $('#jstree-checkbox').on('changed.jstree', function (e, data) {
        if (data.node && data.node.id === 'all') {
            const instance  = $('#jstree-checkbox').jstree(true);
            const isChecked = instance.is_selected(data.node);

            data.node.children.forEach(function (childId) {
                isChecked ? instance.check_node(childId)
                          : instance.uncheck_node(childId);
            });
        }
    });

    /* ---------- 4. Submit form: buang id virtual “all” ---------- */
    $('#formPermission').on('submit', function () {
        const checked = $('#jstree-checkbox').jstree(true)
                        .get_selected(true)
                        .map(n => n.id)
                        .filter(id => id !== 'all');   // hilangkan id virtual
        $('#checkedPermissions').val(checked.join(','));
    });
});
</script>
@endpush