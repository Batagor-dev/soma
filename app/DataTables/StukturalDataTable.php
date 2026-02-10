<?php

namespace App\DataTables;

use App\Models\Stuktural;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StukturalDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('photo', function ($row) {
                $src = $row->photo
                    ? asset('storage/uploads/stuktural/' . $row->photo)
                    : asset('assets/img/avatars/1.png');

                return '<img src="'.$src.'" width="40" height="40" class="rounded-circle">';
            })

            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('stuktural.edit', $row->uuid).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i></a>';

                $delete = '
                    <form action="'.route('stuktural.destroy', $row->uuid).'" method="POST" 
                        style="display:inline-block;" class="delete-form">
                        
                        '.csrf_field().method_field('DELETE').'

                        <button type="button" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="'.$row->uuid.'"
                            data-bs-toggle="tooltip" title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>';

                return $edit.' '.$delete;
            })
            ->rawColumns(['photo', 'action']);
    }

    public function query(Stuktural $model)
    {
        return $model->newQuery()->whereNull('deleted_at');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('stuktural-table')
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
                    'searchPlaceholder' => 'Search struktur...',
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
            Column::make('DT_RowIndex')->title('No')
                ->searchable(false)->orderable(false)->width(30),

            Column::make('photo')->title('Foto')
                ->orderable(false)->searchable(false)->width(60),

            Column::make('unit')->title('Unit'),
            Column::make('jabatan')->title('Jabatan'),
            Column::make('name')->title('Nama'),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120),
        ];
    }

    protected function filename(): string
    {
        return 'Stuktural_' . date('YmdHis');
    }
}
