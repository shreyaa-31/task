<?php

namespace App\DataTables;

use App\Models\SubCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editcolumn('category_id', function ($data) {
                return $data->getCategory['category_name']??" Name not found";
            })

            ->addColumn('action', function ($data) {
                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-success changestatus" status ="0" id="' . $data->id . '"><i class="fa fa-unlock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-primary changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('subcategory_update')) {
                $inactive .=  '<button type="button" class="btn btn-warning m-1 edit" data-toggle="modal" data-target="#editsubcategory" id="' . $data->id . '"><i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('subcategory_delete')) {
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                }
                return $inactive;
            })
            ->editColumn('status',function($data){
                if ($data->status == 1) {
                    return __('lang.Active');
                }else{
                    return __('lang.Inactive');
                }
            })
            ->rawColumns(['category_id','action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SubCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SubCategory $model)
    {
        return $model->with(['getCategory'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('subcategory-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id')->data('DT_RowIndex')->title(__('lang.No')),
            Column::make('category_id')->title(__('lang.Category Name')),
            Column::make('subcategory_name')->title(__('lang.Sub Category Name')),
            Column::make('status')->title(__('lang.Status')),
            Column::computed('action')
            ->title(__('lang.Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SubCategory_' . date('YmdHis');
    }
}