<?php

namespace App\DataTables;

use App\Models\Galery;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GaleryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            // Foto (thumbnail)
            ->addColumn('photo', function ($galery) {
                if (!$galery->photo) return '-';
                $url = asset('storage/' . $galery->photo);
                return '<img src="'.$url.'" alt="'.$galery->title.'" class="img-thumbnail" style="width:90px; height:60px; object-fit:cover;">';
            })

            // Action Button
            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('galery.edit', $row->uuid).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon" 
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="'.route('galery.destroy', $row->uuid).'" method="POST" class="delete-form" style="display:inline-block;">
                        '.csrf_field().method_field("DELETE").'
                        <button type="button" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-id="'.$row->uuid.'" 
                            data-bs-toggle="tooltip" 
                            title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>
                ';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['photo', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Galery $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('galery-table')
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
                    'searchPlaceholder' => 'Search galery...',
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
            Column::make('photo')->title('Photo')->orderable(false)->searchable(false),
            Column::make('title')->title('Title'),
            Column::make('time')->title('Time'),
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
        return 'Galery_' . date('YmdHis');
    }
}