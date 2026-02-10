<?php

namespace App\DataTables;

use App\Models\Banner;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BannerDataTable extends DataTable
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
            ->addColumn('photo', function ($banner) {
                if (!$banner->photo) return '-';
                $url = asset('storage/' . $banner->photo);
                return '<img src="'.$url.'" alt="'.$banner->name.'" class="img-thumbnail" style="width:90px; height:60px; object-fit:cover;">';
            })

            // Status Active/Off (opsional, jika ada)
            ->addColumn('status', function ($banner) {
                if ($banner->status == 1) {
                    return '<span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="ri-checkbox-circle-line me-1"></i> Active
                            </span>';
                }

                return '<span class="badge bg-danger rounded-pill px-3 py-2">
                            <i class="ri-close-circle-line me-1"></i> Non Active
                        </span>';
            })

            // Action Button
            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('banner.edit', $row->uuid).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon" 
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="'.route('banner.destroy', $row->uuid).'" method="POST" class="delete-form" style="display:inline-block;">
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
            ->rawColumns(['photo', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Banner $model)
    {
        return $model->newQuery(); 
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('banner-table')
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
                    'searchPlaceholder' => 'Search banner...',
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
            Column::make('name')->title('Banner Name'),
            Column::make('photo')->title('Photo')->orderable(false)->searchable(false),
            Column::make('link')->title('Link'),
            Column::make('status')->title('Status')->orderable(false)->searchable(false),
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
        return 'Banners_' . date('YmdHis');
    }
}
