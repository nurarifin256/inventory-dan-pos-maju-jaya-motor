<?php

namespace App\DataTables;

use App\Models\jabatans;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\QueryDataTable;
use Yajra\DataTables\Services\DataTable;
use DataTables;

class JabatanDataTables extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->editColumn('created_at', function ($row) {
            //     return $row->created_at->format('d-m-Y H:i:s');
            // })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('d-m-Y H:i:s');
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn_edit = '<button type="button" data-id=' . $row->id . ' data-jenis="edit" class="btn btn-warning btn-sm action"><i class="ti-pencil"></i></button>';
                $btn_delete = '<button type="button" data-id=' . $row->id . ' data-jenis="delete" class="btn btn-danger btn-sm action"><i class="ti-trash"></i></button>';
                return $btn_edit . ' ' . $btn_delete;
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\JabatanDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(jabatans $model): QueryBuilder
    {
        // $model = DB::table('jabatans');
        // return DataTables::queryBuilder($model)->toJson();
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(['searchDelay' => 1000])
            ->setTableId('jabatandatatables-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('created_at'),
            Column::make('created_by'),
            Column::make('updated_at'),
            Column::make('updated_by'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'JabatanDataTables_' . date('YmdHis');
    }
}
