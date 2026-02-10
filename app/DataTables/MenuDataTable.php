<?php

namespace App\DataTables;

use App\Models\Menu;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MenuDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('parent', fn($menu) => $menu->parent?->nama_menu ?? '-')
            ->addColumn('permission_group', fn($menu) => $menu->permissionGroup?->name ?? '-')
            ->addColumn('icon', fn($menu) => $menu->icon ? '<i class="'.$menu->icon.'"></i>' : '-')
            ->addColumn('status', fn($menu) => $menu->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Off</span>')
            ->addColumn('action', function ($row) {
                $edit = '<a href="'.route('menu.edit', $row->uuid).'" class="btn btn-sm btn-text-secondary rounded-pill btn-icon" data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i></a>';

                $delete = '
                            <form action="'.route('menu.destroy', $row->uuid).'" method="POST" style="display:inline-block;" class="delete-form">
                                '.csrf_field().method_field('DELETE').'
                                <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                                    data-id="'.$row->uuid.'"
                                    data-bs-toggle="tooltip" title="Delete">
                                    <i class="ri ri-delete-bin-line icon-20px"></i>
                                </button>
                            </form>';

                return $edit.' '.$delete;
            })
            ->rawColumns(['icon', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Menu $model)
    {
        return $model->with(['parent', 'permissionGroup']); // eager load
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('menu-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(5) // sort by 'sort' column
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
                    'searchPlaceholder' => 'Search menu...',
                    'lengthMenu'    => '_MENU_ Entries',
                    'info'          => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate'      => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next'     => '<i class="ri-arrow-right-s-line"></i>'
                    ],
                ],
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30),
            Column::make('nama_menu')->title('Menu Name'),
            Column::make('parent')->title('Parent')->orderable(false),
            Column::make('icon')->title('Icon')->orderable(false),
            Column::make('href')->title('Link'),
            Column::make('sort')->title('Order'),
            Column::make('permission_group')->title('Permission Group')->orderable(false),
            Column::make('status')->title('Status')->orderable(false),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Menus_' . date('YmdHis');
    }
}