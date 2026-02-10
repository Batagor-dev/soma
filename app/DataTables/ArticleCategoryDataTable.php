<?php

namespace App\DataTables;

use App\Models\ArticleCategory;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArticleCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Article Category Update')) {
                    $edit = '<a href="'.route('article_categories.edit', $row->slug).'"
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line icon-20px"></i>
                             </a>';
                }

                if (auth()->user()->can('Article Category Delete')) {
                    $delete = '
                        <form action="'.route('article_categories.destroy', $row->slug).'"
                              method="POST" style="display:inline-block;" class="delete-form">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-btn"
                                data-id="'.$row->slug.'"
                                data-bs-toggle="tooltip" title="Delete">
                                <i class="ri ri-delete-bin-line icon-20px"></i>
                            </button>
                        </form>';
                }

                return $edit.' '.$delete;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(ArticleCategory $model)
    {
        return $model->newQuery()->where('status', '1');
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('article-categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1) // sort by name
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
                    'searchPlaceholder' => 'Search category...',
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
            Column::make('name')->title('Category Name'),
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
        return 'ArticleCategories_' . date('YmdHis');
    }
}
