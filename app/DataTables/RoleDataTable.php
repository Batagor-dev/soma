<?php

namespace App\DataTables;

use App\Models\Role;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
           ->addColumn('action', function ($row) {
                $detail = '<a href="'.route('role.show', $row->uuid).'" 
                            class="btn btn-sm btn-text-info rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Detail / Permissions">
                            <i class="ri ri-eye-line icon-20px"></i></a>';

                $edit = '<a href="'.route('role.edit', $row->uuid).'" 
                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                        data-bs-toggle="tooltip" title="Edit">
                        <i class="ri ri-edit-line icon-20px"></i></a>';

                $delete = '
                    <form action="'.route('role.destroy', $row->uuid).'" method="POST" style="display:inline-block;" class="delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="'.$row->id.'"
                            data-bs-toggle="tooltip" title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>';

                return $detail.' '.$edit.' '.$delete;
            })
            ->rawColumns(['action']);
    }

    public function query(Role $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('role-table')
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
                    'search'        => 'Search',
                    'searchPlaceholder' => 'Search role...',
                    'lengthMenu'    => '_MENU_ Entries',
                    'info'          => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate'      => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next'     => '<i class="ri-arrow-right-s-line"></i>'
                    ],
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30),
            Column::make('name')->title('Role Name'),
            Column::make('guard_name')->title('Guard'),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}