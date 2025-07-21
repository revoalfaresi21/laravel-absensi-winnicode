<?php

namespace App\DataTables;

use App\Models\PresenceDetail;
use App\Models\Presence;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AbsenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PresenceDetail> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('waktu_absen', function($query){
                return date ('d-m-Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('tanda_tangan', function($query){
                return "<img width='100' src='".asset('uploads/' . $query->tanda_tangan)."'>";
            })
            ->rawColumns(['tanda_tangan'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PresenceDetail>
     */
    public function query(PresenceDetail $model): QueryBuilder{
        $slug = request()->segment(2);
        $presence = Presence::where('slug', $slug)->first();
        
        if (!$presence) {
            // Return empty query if presence not found
            return $model->where('id', -1)->newQuery();
        }
        
        return $model->where('presence_id', $presence->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $slug = request()->segment(2);
        return $this->builder()
                    ->setTableId('absen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('absen.index', $slug))
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->addClass('text-center')
                ->width('100'),
            Column::make('waktu_absen'),
            Column::make('nama'),
            Column::make('jabatan'),
            Column::make('asal_instansi'),
            Column::make('tanda_tangan'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Absen_' . date('YmdHis');
    }
}
