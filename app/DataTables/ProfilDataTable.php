<?php

namespace App\DataTables;

use App\Models\Profil;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProfilDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            // FOTO
            ->addColumn('photo', function ($row) {
                if (!$row->photo) {
                    return '<span class="text-muted">-</span>';
                }

                $url = asset('storage/' . $row->photo);

                return '
                    <img src="'.$url.'"
                         style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                ';
            })

            // POIN (JSON: icon bootstrap + judul + deskripsi)
            ->addColumn('poin', function ($row) {

                if (!$row->poin || !is_array($row->poin)) {
                    return '<span class="text-muted">-</span>';
                }

                $html = '<div class="d-flex flex-column gap-2">';

                foreach ($row->poin as $item) {
                    $icon = $item['icon'] ?? 'bi-dot';
                    $judul = $item['judul'] ?? '';
                    $deskripsi = $item['deskripsi'] ?? '';

                    $html .= '
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi '.$icon.' fs-6 mt-1"></i>
                            <div>
                                <div class="fw-semibold">'.$judul.'</div>
                                <small class="text-muted">'.$deskripsi.'</small>
                            </div>
                        </div>
                    ';
                }

                $html .= '</div>';

                return $html;
            })

            // ACTION
            ->addColumn('action', function ($row) {

                $edit = '
                    <a href="'.route('profil.edit', $row->uuid).'"
                       class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                       data-bs-toggle="tooltip" title="Edit">
                        <i class="ri ri-edit-line icon-20px"></i>
                    </a>
                ';

                $delete = '
                    <form action="'.route('profil.destroy', $row->uuid).'"
                          method="POST"
                          style="display:inline-block;"
                          class="delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button"
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                                data-id="'.$row->uuid.'"
                                data-bs-toggle="tooltip" title="Delete">
                            <i class="ri ri-delete-bin-line icon-20px"></i>
                        </button>
                    </form>
                ';

                return $edit . ' ' . $delete;
            })

            ->rawColumns(['photo', 'poin', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Profil $model)
    {
        return $model->newQuery()
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('profilkomunitas-table')
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
                    'searchPlaceholder' => 'Search profile...',
                    'lengthMenu' => '_MENU_ Entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'previous' => '<i class="ri-arrow-left-s-line"></i>',
                        'next' => '<i class="ri-arrow-right-s-line"></i>',
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

            Column::make('DT_RowIndex')
                ->title('No')
                ->searchable(false)
                ->orderable(false)
                ->width(30),

            Column::computed('photo')
                ->title('Foto')
                ->searchable(false)
                ->orderable(false)
                ->width(70),

            Column::make('judul')
                ->title('Judul'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

            Column::computed('poin')
                ->title('Poin')
                ->searchable(false)
                ->orderable(false)
                ->width(300),

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
        return 'Profil_' . date('YmdHis');
    }
}
