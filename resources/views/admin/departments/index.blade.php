@extends('layouts.master')


@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('lang.Department') }}</h4>

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
                            <div class="card-header-actions">
                                @if(auth()->user()->hasAnyPermission('department_create'))
                                <button class="btn btn-success btn-save float-right" title="Add " id="add_dept" data-toggle="modal" data-target="#department_add_modal" data-id="'.$data->id.'">{{ __('lang.Add') }} </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                            <table class="table table-bordered" id="department-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Department Name')}}</th>
                                            <th>{{__('lang.Status')}}</th>
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

<div class="modal" id="edit-department" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.Update SubCategory') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="dept_edit">

                    <div class="form-group">
                        <label>{{ __('lang.Department Name') }} :</label>
                        <input class="form-control" value="" name="dept_name" id="dept_name" placeholder="{{ __('lang.Type your Department') }}">
                    </div>

                    <input type="hidden" id="hidden_id">

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn" value="submit" class="btn btn-primary">{{ __('lang.Update') }}</button>

            </div>
        </div>
    </div>
</div>

</section>
@include('admin.departments.create')
@endsection

@push('page_scripts')
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

        $('#department-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.getdept') }}",
            language: {
                search: "{{__('lang.search')}}",
                processing:"{{__('lang.processing')}}",
                sInfo: "{{__('lang.sInfo')}}",
                sLengthMenu: "{{__('lang.sLengthMenu')}}",
                sInfoFiltered:"{{__('lang.sInfoFiltered')}}",
                sInfoEmpty:"{{__('lang.sInfoEmpty')}}",
                sZeroRecords:   "{{__('lang.sZeroRecords')}}",
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
                    data: 'dept_name',
                    name: "dept_name",
                    searchable: true
                },
                {
                    data: 'status',
                    name: "status"
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
    $('body').on('click', '.delete', function() {

        swal({
                title: "{{ __('lang.Are you sure?') }}",
                text: "{{ __('lang.Once deleted, you will not be able to recover!') }}",
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
                        url: "{{ route('admin.delete_dept')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("{{ __('lang.Done')}}!", data.message, "success");
                                $('#department-datatable').DataTable().ajax.reload();
                            }


                        },

                    })
                }
            });


    });
    $('body').on('click', '.edit', function() {

        var id = $(this).attr('id');


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('admin.edit_dept')}}",
            method: "post",
            data: {

                id: id,
            },
            dataType: "JSON",
            success: function(data) {
                //   console.log(data.data);
                $('#dept_name').val(data.data.dept_name);
                $('#hidden_id').val(data.data.id);
            }

        })

    });

    $('body').on('click', '#btn', function() {

        var id = $('#hidden_id').val();
        var dept_name = $('#dept_name').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('admin.update_dept')}}",
            method: "post",
            data: {

                id: id,
                dept_name: dept_name,
            },
            dataType: "JSON",
            success: function(data) {
                if (data.status == true)

                {
                    swal("{{ __('lang.Done')}}", data.message, "success");

                    $("#edit-department").modal('hide');
                    $('#department-datatable').DataTable().ajax.reload();
                }

            },
            error: function(response) {
                $('.text-strong').text('');
                $.each(response.responseJSON.errors, function(field_name, error) {
                    $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                })
            }


        })

    })


    $(document).on('click', '.changestatus', function() {


        swal({
                title: "{{ __('lang.Are you sure?') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var status = $(this).attr('status');
                    var id = $(this).attr('id');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('admin.changestatus')}}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == true)

                            {
                                swal("{{ __('lang.Done')}}", data.message, "success");
                                $('#department-datatable').DataTable().ajax.reload();
                            }


                        },

                    })
                }
            });


    })
</script>

@endpush