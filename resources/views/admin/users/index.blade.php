@extends('layouts.master')


@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{__('lang.Registered Users')}}</h4>

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
                                <table class="table table-bordered" id="users-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Profile')}}</th>
                                            <th>{{__('lang.Firstname')}}</th>
                                            <th>{{__('lang.Lastname')}}</th>
                                            <th>{{__('lang.Email')}}</th>
                                            <th>{{__('lang.Category Name')}}</th>
                                            <th>{{__('lang.Sub Category Name')}}</th>
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

<div class="modal" tabindex="-1" role="dialog" id="updateuser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h4 class="text-muted text-center font-18"><b>
                            {{__('lang.Update User') }}</b></h4>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="p-2">
                    <form method="POST" id="update_form">
                        @csrf
                        <div class="form-group">
                            <label for="profile">{{ __('lang.Current Profile') }} :</label>
                            <span id="profile"></span>
                        </div>
                        <div class="form-group">
                            <label for="firstname">{{ __('lang.Firstname') }} :</label>
                            <input id="firstname" type="firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" required autocomplete="firstname" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="lastname">{{ __('lang.Lastname') }} :</label>
                            <input id="lastname" type="lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                        </div>
                        <div class="form-group ">
                            <label for="email">{{ __('lang.Email') }} :</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="category">{{ __('lang.Category') }} :</label>
                            <select class="form-control" name="category" id="category">
                                @foreach ($data as $category)
                                <option value="{{$category->id}}">
                                    {{$category->category_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory">{{ __('lang.SubCategory') }} :</label>
                            <select class="form-control" name="subcategory" id="subcategory">

                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="profile">{{ __('lang.Profile') }} :</label>
                            <input id="u_profile" type="file" class="form-control @error('profile') is-invalid @enderror" name="profile" autocomplete="current-profile">
                        </div>
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                                {{ __('lang.Update') }}
                            </button>
                        </div>
                    </form>
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



            $('#users-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.getuser') }}",
                language: {
                    search: "{{__('lang.search')}}",
                    processing: "{{__('lang.processing')}}",
                    sInfo: "{{__('lang.sInfo')}}",
                    sLengthMenu: "{{__('lang.sLengthMenu')}}",
                    sInfoEmpty: "{{__('lang.sInfoEmpty')}}",
                    sZeroRecords: "{{__('lang.sZeroRecords')}}",
                    sInfoFiltered: "{{__('lang.sInfoFiltered')}}",
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
                        data: 'profile',
                        name: "profile"
                    },
                    {
                        data: 'firstname',
                        name: "firstname",
                        searchable: true
                    },
                    {
                        data: 'lastname',
                        name: "lastname",
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: "email",
                        searchable: true
                    },
                    {
                        data: 'category_id',
                        name: "category_id"
                    },
                    {
                        data: 'subcategory_id',
                        name: "subcategory_id"
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

        $('#category').on('change', function() {
            var catId = $(this).val();
            // console.log(catId);
            $.ajax({
                url: "{{ route('getcat')}}",
                method: "GET",
                data: {
                    catId: catId

                },

                dataType: 'JSON',
                success: function(data) {
                    // console.log(data.data);
                    $("#subcategory").html('<option value="">---Select Subcategory---</option>');
                    $.each(data.data, function(key, value) {
                        $("#subcategory").append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    });
                }
            })

        })
        $(document).on('click', '.update', function() {

            $('.text-strong').html("");
            $('.error').html('');

            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('admin.edit')}}",
                method: "post",
                data: {
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    
                    $("#subcategory").html('');
                    $('#id').val(data.data.user[0].id);
                    $('#firstname').val(data.data.user[0].firstname);
                    $('#lastname').val(data.data.user[0].lastname);
                    $('#email').val(data.data.user[0].email);
                    $("#category").val(data.data.user[0].category_id);

                    $.each(data.subcategory, function(key, value) {
                        // console.log(value.id);
                        $("#subcategory").append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    });
                    $("#subcategory").val(data.data.user[0].subcategory_id);
                    $('#profile').html('<img src="' + /storage/ + "" + /images/ + data.data.user[0].profile + '"height="50px" width="50px"/>');

                }

            })
        })
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");

                $('#update_form').validate({

                    rules: {
                        firstname: {
                            required: true,
                            lettersonly: true,
                        },
                        lastname: {
                            required: true,
                            lettersonly: true,
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        category: {
                            required: true,
                        },
                        subcategory: {
                            required: true,
                        }
                    },
                    messages: {
                        firstname: {
                            required: "{{__('lang.Enter Your Firstname')}}",
                        },
                        lastname: {
                            required: "{{__('lang.Enter Your Lastname')}}",
                        },
                        email: {
                            required: "{{__('lang.Enter Your Email')}}",
                            email: "{{__('lang.Enter Valid Email-Address')}}",

                        },
                        category: {
                            required: "{{__('lang.Select Appropriate Category')}}",
                        },
                        subcategory: {
                            required: "{{__('lang.Select Appropriate SubCategory')}}",
                        }
                    },

                    submitHandler: function(form) {

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },

                            url: "{{ route('admin.update')}}",
                            type: "POST",
                            data: new FormData(form),
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'JSON',
                            success: function(data) {
                                
                                swal("{{__('lang.Done')}}!", data.message, "success");
                                $('#u_profile').val(null);
                                $("#updateuser").modal('hide')
                                $('#users-datatable').DataTable().ajax.reload();
                            },
                            error: function(response) {
                                $('.text-strong').text('');
                                $.each(response.responseJSON.errors, function(field_name, error) {
                                    $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                                })
                            },

                        })
                    }

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
                                    url: "{{ route('admin.gets')}}",
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
                                            $('#users-datatable').DataTable().ajax.reload();
                                        }

                                    },

                                })
                            }
                        })
                }); $(document).on('click', '.delete', function() {
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
                                    url: "{{ route('admin.delete')}}",
                                    method: "POST",
                                    data: {
                                        id: id,
                                    },
                                    success: function(data) {
                                        if (data.status == true)

                                        {
                                            swal("{{__('lang.Done')}}!", data.message, "success");
                                            $('#users-datatable').DataTable().ajax.reload();
                                        }


                                    },

                                })
                            }
                        })
                });
    </script>
    @endpush