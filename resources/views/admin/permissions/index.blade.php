@extends('layouts.master')

@section('page_title', 'Permission')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">@yield('page_title')</h4>

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
                                {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<div class="modal" id="edit-permission" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Permission </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="dept_edit">

                    <div class="form-group">
                        <label>Permission Name :</label>
                        <input class="form-control" value="" name="permission_name" id="permission_name" >
                    </div>

                    <div class="form-group">
                        <label>Guard Name :</label>
                        <input class="form-control" value="" name="guard_name" id="guard_name" >
                    </div>

                    <input type="hidden" id="hidden_id">

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn" value="submit" class="btn btn-primary">Update</button>

            </div>
        </div>
    </div>
</div>

@endsection
@push('page_scripts')
{!! $dataTable->scripts() !!}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $('body').on('click', '.delete', function() {

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
                        url: "{{ route('admin.delete-permission')}}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                swal("Done!", data.message, "success");
                                window.LaravelDataTables["permission-table"].draw();
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
            url: "{{route('admin.edit_permission')}}",
            method: "post",
            data: {
                id: id,
            },
            dataType: "JSON",
            success: function(data) {
                //   console.log(data.guard_name);
                $('#permission_name').val(data.data.name);
                $('#guard_name').val(data.data.guard_name);
                $('#hidden_id').val(data.data.id);
            }

        })

    });

    $('body').on('click', '#btn', function() {

        var id = $('#hidden_id').val();
        var permission_name = $('#permission_name').val();
        var guard_name = $('#guard_name').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('admin.update_permission')}}",
            method: "post",
            data: {

                id: id,
                permission_name: permission_name,
                guard_name:guard_name
            },
            dataType: "JSON",
            success: function(data) {
                if (data.status == true)

                {
                    swal("Done!", data.message, "success");

                    $("#edit-permission").modal('hide');
                    window.LaravelDataTables["permission-table"].draw();
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
</script>
@endpush