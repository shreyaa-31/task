@extends('layouts.master')



@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('lang.Admin User') }}</h4>

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
                                <button class="btn btn-success btn-save float-right" title="Add " id="addcat" data-toggle="modal" data-target="#admin_add_modal" data-id="'.$data->id.'">{{ __('lang.Add') }} </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="adminuser-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Name')}}</th>
                                            <th>{{__('lang.Email')}}</th>
                                            <th>{{__('lang.Role')}}</th>
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


<div class="modal" id="edit-admin-user" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.Update User') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editadmin">

                    <div class="form-group">
                        <label>{{ __('lang.Name') }} :</label>
                        <input type="text" class="form-control" value="" name="name" id="name">
                        <span class="error-msg-input text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.Email') }} :</label>
                        <input type="email" class="form-control" value="" name="email" id="email">
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.Role') }} :</label>
                        <select class="form-control" name="role" id="role">
                            <option value="">{{ __('lang.--Select--') }}</option>
                            @foreach ($data as $role)
                            <option value="{{$role->id}}">
                                {{$role->name}}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="id" name="id">
                    </div>


                    <div class="modal-footer">
                        <button type="submit" id="btn" value="submit" class="btn btn-primary">{{ __('lang.Update') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

@include('admin.admin_user.create')
@endsection
@push('page_scripts')

{!! $dataTable->scripts() !!}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

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

        $('#adminuser-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.admin-user-list') }}",
            language: {
                search: "{{__('lang.search')}}",
                processing: "{{__('lang.processing')}}",
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
                    data: 'name',
                    name: "name",
                    searchable: true
                },
                {
                    data: 'email',
                    name: "email",
                    searchable: true
                },
                {
                    data: 'assign_role',
                    name: "assign_role",
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

    $(document).on('click', '.edit', function() {
        $(".error").html("");
        $(".text-strong").html("");
        id = $(this).attr('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.get-admin-data')}}",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                $('#name').val(data.data.name);
                $('#email').val(data.data.email);
                $('#role').val(data.data.assign_role);
                $('#id').val(data.data.id);
            }
        })
    })

    $(document).on('click', '.delete', function() {
        id = $(this).attr('id');
        console.log(id);
    });

    $('#editadmin').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            role: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "{{__('lang.This field is required')}}",
            },
            email: {
                required: "{{__('lang.This field is required')}}",
            },
            role: {
                required: "{{__('lang.This field is required')}}",
            },
        },
        submitHandler: function(form) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.admin-update')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        $('#edit-admin-user').modal('hide');
                        swal("{{__('lang.Done')}}!", data.message, "success");
                        
                        $('#adminuser-datatable').DataTable().ajax.reload();
                    }
                },
                error: function(response) {
                    $('.text-strong').text('');
                    $.each(response.responseJSON.errors, function(field_name, error) {
                        $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                    })
                }
            })
        }
    })

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
                        url: "{{ route('admin.admin-delete')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("{{__('lang.Done')}}!", data.message, "success");
                                $('#adminuser-datatable').DataTable().ajax.reload();
                            }


                        },

                    })
                }
            });



    })
</script>
@endpush