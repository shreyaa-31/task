<?php

namespace App\DataTables;

use App\Models\Employee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
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
        
            ->addColumn('action', function ($data) {

                $inactive = "";
                if ($data->status == 1) {
                    $inactive .= '<button type="button" class="btn btn-success m-1 changestatus" status ="0" id="' . $data->id . '"> <i class="fa fa-unlock"></i></button>';
                } else {
                    $inactive .= '<button type="button" class="btn btn-primary   m-1 changestatus" status ="1" id="' . $data->id . '"><i class="fa fa-lock"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('employees_update')) {
                $inactive .=  '<button type="button" class="btn btn-warning m-1 edit " data-toggle="modal" id="' . $data->id . '"  data-target="#employee_add_modal" ><i class="fa fa-edit"></i></button>';
                }
                if (auth()->user()->hasAnyPermission('employees_delete')) {
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
            ->editColumn('gender', function ($data) {
                if ($data->gender == 1) {
                    return __('lang.Female');
                } else {
                    return __('lang.Male');
                }
            })

            ->editcolumn('dept_id', function ($data) {
                return $data->getDept['dept_name'];
            })

            ->rawColumns(['gender','action','dept_id'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employee-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('excel'),
                Button::make('csv'),
                
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
            Column::make('emp_name')->title(__('lang.Employee Name')),
            Column::make('mobile')->title(__('lang.Mobile No')),
            Column::make('email')->title(__('lang.Email')),
            Column::make('gender')->title(__('lang.Gender')),
            Column::make('dept_id')->title(__('lang.Department Name')),
            Column::make('dob')->title(__('lang.Date of Birth')),
            Column::make('emp_joining_date')->title(__('lang.Date of Join')),
            Column::make('status')->title(__('lang.Status')),
            Column::computed('action')
            ->title(__('lang.Action'))
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
    protected function filename()
    {
        return 'Employee_' . date('YmdHis');
    }
}
