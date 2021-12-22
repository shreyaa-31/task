<div class="modal fade" id="department_add_modal" role="dialog" aria-modal="true" aria-labelledby="category_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{ __('lang.Add Department') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="POST" enctype="multipart/form-data" id="add_department_form">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('lang.Department Name') }} :</label>
                        <input id="dept_name" class="form-control" name="dept_name" placeholder="{{ __('lang.Type your Department') }}">
                    </div>
                    @if ($errors->has('department_name'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('department_name') }}</strong>
                    </span>
                    @endif

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">{{ __('lang.Add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>

$("#add_dept").click(function(){
 
 $(".error").html("");
 $(".text-strong").html("");
 $('#add_department_form').get(0).reset();
});
    $('#add_department_form').validate({

        rules: {
            dept_name: {
                required: true,
            }
        },

        messages: {
            dept_name: {
                required: "{{__('lang.This field is required')}}",
            }
        },
        submitHandler: function(form) {
            // console.log(form);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.dept_store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true)

                    {
                        swal("{{ __('lang.Done')}}", data.message, "success");
                        $('#add_department_form').get(0).reset();
                        $('#department_add_modal').modal('hide');
                        $('#department-datatable').DataTable().ajax.reload();
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
</script>