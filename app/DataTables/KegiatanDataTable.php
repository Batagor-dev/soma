<?php

namespace App\DataTables;

use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KegiatanDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            // Deskripsi 
            ->addColumn('deskripsi', function ($kegiatan) {
                return '<span title="'.$kegiatan->deskripsi.'">'
                        . Str::limit($kegiatan->deskripsi, 60) .
                       '</span>';
            })

            // Photo thumbnail
            ->addColumn('photo', function ($kegiatan) {
                if (!$kegiatan->photo) return '-';

                $url = asset('storage/' . $kegiatan->photo);

                return '<img src="'.$url.'" alt="'.$kegiatan->title.'" 
                            class="img-thumbnail" 
                            style="width:90px; height:60px; object-fit:cover;">';
            })

            // Format waktu
            ->addColumn('waktu', function ($kegiatan) {
                return $kegiatan->waktu
                    ? $kegiatan->waktu->format('d M Y')
                    : '-';
            })


            // Action button
            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('kegiatan.edit', $row->uuid).'" 
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line icon-20px"></i>
                        </a>';

                $delete = '
                    <form action="'.route('kegiatan.destroy', $row->uuid).'" 
                          method="POST" 
                          class="delete-form" 
                          style="display:inline-block;">
                        '.csrf_field().method_field("DELETE").'
                        <button type="button"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                            data-bs-toggle="tooltip"
                            title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>
                ';

                return $edit . ' ' . $delete;
            })

            ->rawColumns(['deskripsi', 'photo', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Kegiatan $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('kegiatan-table')
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
                    'search'            => 'Search',
                    'searchPlaceholder' => 'Search kegiatan...',
                    'lengthMenu'        => '_MENU_ Entries',
                    'info'              => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate'          => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next'     => '<i class="ri-arrow-right-s-line"></i>',
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
        Column::make('deskripsi')->title('Deskripsi')->orderable(false),
        Column::make('waktu')->title('Waktu'),
        Column::computed('action')->title('Action')->exportable(false)->printable(false)->width(120),
    ];
}



    protected function filename(): string
    {
        return 'Kegiatan_' . date('YmdHis');
    }
}
