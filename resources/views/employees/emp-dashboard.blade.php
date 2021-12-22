@extends('employees.employee-layouts.master')

@section('page_title', 'Employee')

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
                            <div class="card-header-actions">
                                <span id="ct5"></span>

                                <body onload=display_ct5();>

                                    <button type="button" class="btn btn-success float-right" id="clock-in">
                                        Clock In
                                    </button>
                                    <button type="button" class="btn btn-danger btn-save float-right"  id="clock-out">Clock Out </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ajax-msg"></div>
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
</section>


@endsection

<div class="modal" id="task" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-comment">
                    <div class="form-group">
                        <input type="text" class="form-control" name="comment" id="comment" placeholder="Type your Comments" required>
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <input type="hidden" value="{{Auth::guard('employee')->user()->id}}" id="emp_id">
                    <input type="hidden" value="" id="id">

                    <div class="modal-footer">
                        <button type="submit" value="submit" id="submit" name="submit" class="btn btn-primary comment">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







@push('page_scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    $("#clock-out").css("display", "none");

    function display_ct5() {
        var x = new Date();
        var x2 = x.getMonth()+1;
        var x1 = "Date: " +x.getDate() + "-" + x2 +"-" +  x.getFullYear();
        x1 = x1 + "  Time: " + x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();
        document.getElementById('ct5').innerHTML = x1;
        display_c5();
    }

    function display_c5() {
        var refresh = 1000; 
        mytime = setTimeout('display_ct5()', refresh)
    }
    display_c5();



    $('#add-comment').validate({
        rules: {
            commment: {
                required: true,
            }
        },
        messages: {
            commment: {
                required: "Required",
            }
        },
        submitHandler: function(form) {
            id = $('#emp_id').val();
            comment = $('#comment').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('store-attendance')}}",
                method: "POST",
                data: {
                    id: id,
                    comment: comment,
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data.data);
                    if (data.status == true) {
                        $('#id').val(data.data.id);
                        $('#clock-in').css('display', 'none');
                        $('#clock-out').css('display', "");
                        swal("Done!", data.message, "success");
                        $('#task').modal('hide');

                    }

                }

            })
        }
    });

    $('#clock-in').click(function() {
        $('#task').modal('show');
        $('#add-comment').validate().resetForm();
    });

    $('#clock-out').click(function() {
        id = $('#id').val();
            

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{route('update-attendance')}}",
            method: "POST",
            data: {
                id: id,
                
            },
            dataType: "JSON",
            success: function(data) {
                // console.log(data.status);
                if (data.status == true) {
                    $('#clock-out').css('display', 'none');
                    $('#clock-in').css('display', "");
                    swal("Done!", data.message, "success");
                    

                }

            }

        })
    });
</script>
@endpush