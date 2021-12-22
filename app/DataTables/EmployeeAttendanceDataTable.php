<?php

namespace App\DataTables;

use App\Models\EmployeeAttendance;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class EmployeeAttendanceDataTable extends DataTable
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
            ->addColumn('action', function ($data){

                $inactive = "";

                $inactive .=  '<button type="button" class="btn btn-success m-1 show " data-toggle="modal" data-target="#show-cmnt" id="' . $data->date . '" ><i class="fa fa-eye"></i></button>';
                if (auth()->user()->hasAnyPermission('employees-attendences_delete')) {
                $inactive .=  '<button type="button" class="btn btn-danger m-1 delete" id="' . $data->id . '"><i class="fa fa-trash"></i></button>';
                }


                return $inactive;
            })
            ->addColumn('clock-in', function ($data){
                
                $inactive = EmployeeAttendance::where('emp_id',$data->emp_id)->where('date',$data->date)->count();

               
                return $inactive;
            })
            ->addColumn('working hour', function ($data){
                
                $diff = EmployeeAttendance::where('emp_id',$data->emp_id)->where('date',$data->date)
                ->get(['start_time','end_time']);
                $difference = 0;
               
              foreach($diff as $d){
                  $d1 = strtotime($d['end_time']);
                  $d2 = strtotime($d['start_time']);
                 
                  if($d1 == ''){
                      return "Working";
                  }else{
                    $di = abs($d1 - $d2);
                    $difference = $di/60/60 + $difference;
                  }
                  
              }
               $working_hr = floor($difference);
               $working_min = round(($difference - $working_hr)*60);
               $diff1 = $working_hr."hr"." ".$working_min."min";
                return $diff1;
               
               
            })

            ->addColumn('comment',function($data){
                $comment = EmployeeAttendance::where('emp_id',$data->emp_id)->where('date',$data->date)->get('comment');
                
                foreach($comment as $c){
                    $cmnt[] = $c['comment'];
                }
               return $cmnt;
            })
           
            ->editcolumn('emp_id', function ($data) {
                return $data->getemp['emp_name'];
            })   
            ->rawColumns(['action','emp_id','clock-in'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmployeeAttendance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmployeeAttendance $model)
    {
        return $model->newQuery()->groupBy('emp_id')->groupBy('date');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('employeeattendance-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('excel'),
                        Button::make('csv')
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
            Column::make('emp_id')->title(__('lang.Employee Name'))->searchable(),
            Column::make('date')->title(__('lang.Date')),
            Column::make('clock-in')->title(__('lang.Clock-in')),
            Column::make('working hour')->title(__('lang.Working-hr')),
            Column::make('comment')->searchable()->title(__('lang.Comment')),
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
        return 'EmployeeAttendance_' . date('YmdHis');
    }
}



