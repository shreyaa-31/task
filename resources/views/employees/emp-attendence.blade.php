@extends('layouts.master')


@section('content')


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('lang.Employee Work Report') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active"></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">


                                <label>{{__('lang.Employee Name')}} </label>
                                <select class="col-2" name="emp_name" id="emp_name">
                                    <option value="">{{__('lang.--Select--')}}</option>
                                    @foreach($data as $d)
                                    <option value="{{$d->id}}">{{$d->emp_name}}</option>
                                    @endforeach
                                </select>

                                <input type="text" name="daterange" id="daterange">
                                <button type="button" class="btn btn-primary m-1 show-data ">{{ __('lang.Show') }}</button>

                                <table class="table table-bordered" id="employeeattendance-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Employee Name')}}</th>
                                            <th>{{__('lang.Date')}}</th>
                                            <th>{{__('lang.Clock-in')}}</th>
                                            <th>{{__('lang.Working-hr')}}</th>
                                            <th>{{__('lang.Comment')}}</th>
                                            <th>{{__('lang.Action')}}</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<div class="modal" id="show-cmnt" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.Employee Work Report') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="show-comment">
                    <div id="date"></div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('lang.Comment')}}</th>
                                <th>{{ __('lang.Start-Time')}}</th>
                                <th>{{ __('lang.End-Time')}}</th>
                                <th>{{ __('lang.Working-hr')}}</th>
                            </tr>
                        </thead>
                        <tbody id="comments">

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="show-data" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.Employees Monthly Report') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="show-comment">
                    <div id="date"></div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('lang.Date')}}</th>
                                <th>{{ __('lang.Comment')}}</th>
                                <th>{{ __('lang.Working-hr')}}</th>
                            </tr>
                        </thead>
                        <tbody id="monthly">

                        </tbody>
                    </table>

                    <label>{{ __('lang.Total hour')}}</label>
                    <span id="total"></span>

                    <input type="hidden" id="emp_name" name="emp_name">
                    <input type="hidden" id="daterange" name="daterange">


                    <button type="button" class="btn btn-primary excel-data">{{ __('lang.ExportData')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection

@push('page_scripts')


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap4.min.css" />


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>


<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker();

    });
</script>

<link href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.bootstrap4.min.js"></script>

<script>
    
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#employeeattendance-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.employee-attendences') }}",
            language: {
                search: "{{__('lang.search')}}",
                processing: "{{__('lang.processing')}}",
                sInfo: "{{__('lang.sInfo')}}",
                sLengthMenu: "{{__('lang.sLengthMenu')}}",
                sInfoEmpty:"{{__('lang.sInfoEmpty')}}",
                sZeroRecords:   "{{__('lang.sZeroRecords')}}",
                sInfoFiltered:"{{__('lang.sInfoFiltered')}}",
                oPaginate: {
                    sFirst: "{{__('lang.oPaginate.sFirst')}}",
                    sPrevious: "{{__('lang.oPaginate.sPrevious')}}",
                    sNext: "{{__('lang.oPaginate.sNext')}}",
                    sLast: "{{__('lang.oPaginate.sLast')}}"
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'emp_id',
                    name: "emp_id",
                    searchable: true
                },
                {
                    data: 'date',
                    name: "date",
                    searchable: true
                },
                {
                    data: 'clock-in',
                    name: "clock-in",
                    searchable: true
                },
                {
                    data: 'working hour',
                    name: "working hour",
                    searchable: true
                },
                {
                    data: 'comment',
                    name: "comment",
                    searchable: true
                },
                {
                    data: 'action',
                    name: "action",
                    orderable: false
                }
            ],
            order: [
                [0, 'desc']
            ]
        });
    });
    $('.excel-data').click(function() {
        id = $('#emp_name').val();
        daterange = $('#daterange').val();
        let url = "{{ route('admin.export')}}"
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.export')}}",
            method: "GET",
            data: {
                id: id,
                daterange: daterange
            },
            success: function(data) {

                window.open(url, '_blank');

                console.log(data);
            }
        })
    })








    $(document).on('click', '.show', function() {
        date = $(this).attr('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.show-comments')}}",
            method: "POST",
            data: {
                date: date,
            },
            success: function(data) {


                $('#date').html(data.date);
                my_data = '';
                $.each(data.data.comment, function(index, value) {

                    my_data += '<tr><td>' + value + '</td>';
                    $.each(data.data.start_time, function(idx2, value) {
                        if (index == idx2) {
                            my_data += '<td>' + value + '</td>';
                            $.each(data.data.end_time, function(idx1, value) {
                                if (idx2 == idx1) {
                                    my_data += '<td>' + value + '</td>';
                                    $.each(data.data.working_hr, function(idx3,
                                        value) {
                                        if (idx3 == idx2) {
                                            my_data += '<td>' + value +
                                                '</td></tr>';
                                        }

                                    })
                                }

                            })
                        }

                    })
                })

                $('#comments').html(my_data);

            }
        })
    });

    $(document).on('click', '.delete', function() {

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var id = $(this).attr('id');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('admin.delete-emp-attendences')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("Done!", data.message, "success");
                                $('#employeeattendance-datatable').DataTable().ajax.reload();
                            }
                        },

                    })
                }
            });

    })



    $(document).on('click', '.show-data', function() {
        id = $('#emp_name').val();
        daterange = $('#daterange').val();
        // console.log(date);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('admin.show')}}",
            method: "POST",
            data: {
                id: id,
                daterange: daterange
            },
            success: function(data) {
                if (data.status == true) {
                    $('#show-data').modal('show');
                    my_data = '';
                    $.each(data.data.date, function(index, value) {
                        my_data += '<tr><td>' + value + '</td>';
                        $.each(data.data.comment, function(idx, value) {
                            if (idx == index) {
                                my_data += '<td>' + value + '</td>';
                                $.each(data.data.working_hr, function(idx1, value) {
                                    if (idx == idx1) {
                                        my_data += '<td>' + value + '</td></tr>';

                                    }

                                })
                            }

                        })
                    })

                    $('#monthly').html(my_data);
                    $('#emp_name').val(data.data.export.id);
                    $('#daterange').val(data.data.export.daterange);
                    $('#total').html(data.data.total_hr);
                }
                swal("Danger!", data.message, "error");

            }
        })
    });
</script>


@endpush