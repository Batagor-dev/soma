<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('foto', function ($row) {
                $src = $row->foto == '1.png'
                    ? asset('assets/img/avatars/' . $row->foto)
                    : asset('storage/uploads/avatars/' . $row->foto);

                return '<img src="'.$src.'" width="40" height="40" class="rounded-circle">';
            })
            ->addColumn('action', function ($row) {
                $detail = '<a href="'.route('user.role', $row->uuid).'" 
                            class="btn btn-sm btn-text-info rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Detail / Permissions">
                            <i class="ri ri-eye-line icon-20px"></i></a>';

                $edit = '<a href="'.route('user.edit', $row->uuid).'" 
                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                        data-bs-toggle="tooltip" title="Edit">
                        <i class="ri ri-edit-line icon-20px"></i></a>';

                $delete = '
                            <form action="'.route('user.destroy', $row->uuid).'" method="POST" style="display:inline-block;" class="delete-form">
                                '.csrf_field().method_field('DELETE').'
                                <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                                    data-id="'.$row->uuid.'"
                                    data-bs-toggle="tooltip" title="Delete">
                                    <i class="ri ri-delete-bin-line icon-20px"></i>
                                </button>
                            </form>';

                return $detail.' '.$edit.' '.$delete;
            })
            ->rawColumns(['foto', 'action']);
    }

    public function query(User $model)
    {
        return $model->newQuery()->whereNull('banned_at');;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->responsive(true)
            ->addTableClass('table table-bordered table-hover align-middle bg-white')
            ->parameters([
                'dom' => '<"row mb-3"
                              <"col-md-6 d-flex align-items-center"l>
                              <"col-md-6 d-flex justify-content-end"f>
                           >
                           <"table-responsive"tr>
                           <"row mt-3"
                              <"col-md-6"i>
                              <"col-md-6 d-flex justify-content-end"p>
                           >',
                'language' => [
                    'search' => 'Search',
                    'searchPlaceholder' => 'Search user...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>'
                    ],
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30),
            Column::make('foto')->title('Foto')->orderable(false)->searchable(false)->width(60),
            Column::make('username')->title('Username'),
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
