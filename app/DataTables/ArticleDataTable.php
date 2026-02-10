<?php

namespace App\DataTables;

use App\Models\Article;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArticleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('image', function ($article) {
                return $article->image_path
                    ? '<img src="'.asset('storage/'.$article->image_path).'" class="img-fluid rounded" style="max-height:80px;">'
                    : '<span class="badge bg-secondary">No Image</span>';
            })
            ->addColumn('category', fn($article) => $article->category?->name ?? '-')
            ->addColumn('author', fn($article) => $article->author?->name ?? '-')
            ->addColumn('published_at', fn($article) => $article->published_at
                ? \Carbon\Carbon::parse($article->published_at)->isoFormat('dddd, D MMMM Y')
                : '-'
            )
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Article Update')) {
                    $edit = '<a href="'.route('article.edit', $row->slug).'"
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line icon-20px"></i>
                             </a>';
                }

                if (auth()->user()->can('Article Delete')) {
                    $delete = '
                        <form action="'.route('article.destroy', $row->slug).'"
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
            ->rawColumns(['image', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Article $model)
    {
        return $model->newQuery()->with(['category', 'author']);
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('articles-table')
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
                    'searchPlaceholder' => 'Search article...',
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
            Column::make('image')->title('Image')->orderable(false)->searchable(false),
            Column::make('title')->title('Article'),
            Column::make('category')->title('Category'),
            Column::make('author')->title('Author'),
            Column::make('published_at')->title('Published At'),
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
        return 'Articles_' . date('YmdHis');
    }
}
