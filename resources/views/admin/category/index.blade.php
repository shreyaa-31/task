@extends('layouts.master')


@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('lang.Category') }}</h4>

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
                                @if(auth()->user()->hasAnyPermission('category_create'))
                                <button class="btn btn-success btn-save float-right" title="Add " id="addcat" data-toggle="modal" data-target="#category_add_modal" data-id="'.$data->id.'">{{ __('lang.Add') }} </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="category-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Category Name')}}</th>
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

<div class="modal" id="editcategory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.Update Category') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editcat">

                    <div class="form-group">
                        <label>{{ __('lang.Category Name') }} :</label>
                        <input type="text" class="form-control" value="" name="category_name" id="category_name" placeholder="Type your Category">
                        <span class="error-msg-input text-danger"></span>
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
@include('admin.category.create')
@endsection
@push('page_scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

        $('#category-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.category.dataTable') }}",
            language: {
                search: "{{__('lang.search')}}",
                show: "{{__('lang.show')}}",
                entries: "{{__('lang.entries')}}",
                processing: "{{__('lang.processing')}}",
                sInfo: "{{__('lang.sInfo')}}",
                sInfoEmpty:"{{__('lang.sInfoEmpty')}}",
                sInfoFiltered:"{{__('lang.sInfoFiltered')}}",
                sZeroRecords:   "{{__('lang.sZeroRecords')}}",
                sLengthMenu: "{{__('lang.sLengthMenu')}}",
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
                    data: 'category_name',
                    name: "category_name"
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
    $(document).on('click', '.delete', function() {
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
                        url: "{{ route('admin.category.deletecategory')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("{{__('lang.Done')}}!", data.message, "success");
                                $('#category-datatable').DataTable().ajax.reload();                            }


                        },

                    })
                }
            });



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
                        url: "{{ route('admin.category.getstatus')}}",
                        method: "POST",
                        data: {
                            id: id,
                            status: status,
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == true)

                            {
                                swal("{{__('lang.Done')}}!", data.message, "success");
                                $('#category-datatable').DataTable().ajax.reload(); 
                            }


                        },

                    })
                }
            });


    })

    $(document).on('click', '#btn', function() {

        var id = $('#hidden_id').val();
        // console.log(id);
        var category_name = $('#category_name').val();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.category.updatecategory')}}",
            method: "post",
            data: {
                id: id,
                category_name: category_name
            },
            success: function(data) {
                if (data.status == true)

                {
                    swal("{{__('lang.Done')}}!", data.message, "success");
                    $("#editcategory").modal('hide');
                    $('#category-datatable').DataTable().ajax.reload(); 
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

    $(document).on('click', '.edit', function() {

        var id = $(this).attr('id');
        //    console.log(id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.category.getcategory')}}",
            method: "post",
            data: {

                id: id,
            },
            success: function(data) {
                //   console.log(data.data);
                $('#category_name').val(data.data.category_name);
                $('#hidden_id').val(data.data.id);
            }

        })

    })
</script>

@endpush