@extends('layouts.master')


@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{__('lang.Employees')}}</h4>

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
                                @if(auth()->user()->hasAnyPermission('employees_create'))
                                <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal" data-target="#employee_add_modal" id="add">{{__('lang.Add')}} </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="employee-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Employee Name')}}</th>
                                            <th>{{__('lang.Mobile No')}}</th>
                                            <th>{{__('lang.Email')}}</th>
                                            <th>{{__('lang.Gender')}}</th>
                                            <th>{{__('lang.Department Name')}}</th>
                                            <th>{{__('lang.Date of Birth')}}</th>
                                            <th>{{__('lang.Date of Join')}}</th>
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


<div class="modal" id="employee_add_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{__('lang.Employee')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'id' => 'add_employee_form']) !!}


                <div class="form-group">
                    {{ form::label('emp_name',__('lang.Employee Name'))}}
                    {{form::text('emp_name','',['class'=>'form-control','placeholder'=>__('lang.Employee Name')])}}
                </div>
                <div class="form-group">
                    {{ form::label('mobile',__('lang.Mobile No'))}}
                    {{form::text('mobile','',['class'=>'form-control','placeholder'=>__('lang.Mobile No')])}}
                </div>
                <div class="form-group">
                    {{ form::label('email',__('lang.Email'))}}
                    {{form::text('email','',['class'=>'form-control','placeholder'=>__('lang.Email')])}}
                </div>

                <div class="form-group">
                    {{ Form::label('gender',__('lang.Gender'))}}
                    <div class="form-check form-check-inline">
                        {{ Form::label('gender',__('lang.Male'))}}
                        {{ Form::radio('gender', '2','',['id'=>'male']) }}

                        {{ Form::label('gender',__('lang.Female'))}}
                        {{ Form::radio('gender', '1','',['id'=>'female']) }}


                    </div>
                </div>
                <div class="form-group">

                    {{ form::label('dept_name',__('lang.Department Name'))}}

                    {!! Form::select('dept_name', $dept, $dept, ['class'=>'form-control']) !!}

                </div>
                <div class="form-group">
                    {{ form::label('dob',__('lang.Date of Birth'))}}
                    {{form::date('dob','',['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    {{ form::label('emp_joining_date',__('lang.Date of Join'))}}
                    {{form::date('emp_joining_date','',['class'=>'form-control'])}}
                </div>

                <div class="form-group">
                    {{ form::label('password',__('lang.Password'))}}
                    {{ Form::password('password',['class'=>'form-control','placeholder'=>__('lang.Password')]) }}
                </div>

                {{form::hidden('hidden_id','',['id'=>'hidden_id'])}}
                {{Form::submit(__('lang.Submit'), ['class'=>'btn btn-primary'])}}


                {!!Form::close()!!}
            </div>

        </div>
    </div>
</div>


@endsection

@push('page_scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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

        $('#employee-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.employee') }}",
            language: {
                search: "{{__('lang.search')}}",
                processing: "{{__('lang.processing')}}",
                info: "{{__('lang.sInfo')}}",
                sInfoEmpty:"{{__('lang.sInfoEmpty')}}",
                sZeroRecords:   "{{__('lang.sZeroRecords')}}",
                sLengthMenu: "{{__('lang.sLengthMenu')}}",
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
                    data: 'emp_name',
                    name: "emp_name",
                },
                {
                    data: 'mobile',
                    name: "mobile",
                    searchable: true
                },
                {
                    data: 'email',
                    name: "email",
                    searchable: true
                },
                {
                    data: 'gender',
                    name: "gender",
                    searchable: true
                },
                {
                    data: 'dept_id',
                    name: "dept_id"
                },
                {
                    data: 'dob',
                    name: "dob"
                },

                {
                    data: 'emp_joining_date',
                    name: "emp_joining_date"
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
    $('#add').click(function() {

        $("#hidden_id").val('');
        $("input").removeAttr("checked");
        $('.text-strong').html('');

        $("#add_employee_form").get(0).reset();
        $("#add_employee_form").validate().resetForm();
    });


    $.validator.addMethod("before", function(value, element) {
        var today = new Date();
        var joinDate = new Date(value);
        if (joinDate <= today) {
            return true;
        }
    }, "{{__('lang.before')}}");



    $.validator.addMethod("minAge", function(value, element, min) {

        var today = new Date();
        var birthDate = new Date(value);
        var age = today.getFullYear() - birthDate.getFullYear();

        if (age > min + 1) {
            return true;
        }

        var m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age >= min;

    }, "{{__('lang.minAge')}}");

    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "{{__('lang.lettersonly')}}");

    $('#add_employee_form').validate({
        rules: {
            emp_name: {
                required: true,
                lettersonly: true,
            },
            mobile: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
                remote: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: "{{route('admin.checkmobile')}}",
                    data: {
                        mobile: function() {
                            return $("#mobile").val()
                        },
                        hidden_id: function() {
                            return $("#hidden_id").val()
                        },
                    }

                }
            },
            email: {
                required: true,
                email: true,
                remote: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: "{{route('admin.checkmail')}}",
                    data: {
                        email: function() {
                            return $("#email").val();
                        },
                        hidden_id: function() {
                            return $("#hidden_id").val()
                        },
                    },

                }
            },
            gender: {
                required: true,
            },
            dept_name: {
                required: true,
            },
            dob: {
                required: true,
                minAge: 18,
            },
            emp_joining_date: {
                required: true,
                before: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            emp_name: {
                required: "{{__('lang.This field is required')}}",
            },
            mobile: {
                required: "{{__('lang.This field is required')}}",
                digits: "{{__('lang.digits')}}",
                minlength: "{{__('lang.minlength')}}",
                maxlength: "{{__('lang.maxlength')}}",
                remote: "{{__('lang.mremote')}}",
            },
            email: {
                required: "{{__('lang.This field is required')}}",
                email: "{{__('lang.email')}}",
                remote: "{{__('lang.eremote')}}",
            },
            gender: {
                required: "{{__('lang.This field is required')}}",
            },
            dept_name: {
                required: "{{__('lang.This field is required')}}",
            },
            dob: {
                required: "{{__('lang.This field is required')}}",

            },
            emp_joining_date: {
                required: "{{__('lang.This field is required')}}",
            },
            password: {
                required: "{{__('lang.This field is required')}}",
            }
        },
        submitHandler: function(form) {
            // alert(123);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('admin.emp_store')}}",
                method: "post",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.status == true) {
                        swal("{{__('lang.Done')}}!", data.message, "success");
                        $('#employee_add_modal').modal('hide');
                        $('#employee-datatable').DataTable().ajax.reload(); 
                    }
                },

                error: function(response) {
                    $('.text-strong').text('');
                    $.each(response.responseJSON.errors, function(field_name, error) {
                        $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                    })
                }
            });
        }
    });

    $(document).on('click', '.delete', function() {

        swal({
                title: "{{__('lang.Are you sure?')}}",
                text: "{{__('lang.Once deleted, you will not be able to recover!')}}",
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
                        url: "{{ route('admin.delete_emp')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("{{__('lang.Done')}}!", data.message, "success");
                                $('#employee-datatable').DataTable().ajax.reload(); 
                            }


                        },

                    })
                }
            });

    })



    $(document).on('click', '.edit', function() {
        $("#add_employee_form").validate().resetForm();
        $('.text-strong').html('');
        $("input").removeAttr("checked");
        var id = $(this).attr('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.get_emp_details')}}",
            method: "post",
            data: {
                id: id,
            },
            success: function(data) {
                // console.log(data.data);
                $('#emp_name').val(data.data.emp_name);
                $('#mobile').val(data.data.mobile);
                $('#email').val(data.data.email);
                $('#hidden_id').val(data.data.id);
                $('#dob').val(data.data.dob);
                $('#dept_name').val(data.data.dept_id);
                $('#emp_joining_date').val(data.data.emp_joining_date);
                if (data.data.gender == 2) {
                    $('#male').attr("checked", "checked");
                } else {
                    $('#female').attr("checked", "checked");
                }

            }

        })

    })


    $(document).on('click', '.changestatus', function() {


        swal({
                title: "{{__('lang.Are you sure?')}}",
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
                        url: "{{ route('admin.change-status')}}",
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
                                $('#employee-datatable').DataTable().ajax.reload(); 
                            }


                        },

                    })
                }
            });


    })
</script>

@endpush