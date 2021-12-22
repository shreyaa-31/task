<div class="modal fade" id="admin_add_modal" role="dialog" aria-modal="true" aria-labelledby="admin_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{ __('lang.Add User') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="add_admin_form">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('lang.Name') }}: </label>
                        <input type="text" class="form-control" name="admin_name" id="admin_name" placeholder="{{ __('lang.Name') }}">


                        @if ($errors->has('name'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.Email') }} :</label>
                        <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="{{ __('lang.Email') }}">

                        @if ($errors->has('email'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.Password') }} :</label>
                        <input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="{{ __('lang.Password') }}">

                        @if ($errors->has('password'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.Role') }} :</label>
                        <select class="form-control" name="admin_role" id="admin_role">
                            <option value="">{{ __('lang.--Select--') }}</option>
                            @foreach ($data as $role)
                            <option value="{{$role->id}}">
                                {{$role->name}}
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                        @endif
                    </div>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>



<script>
    $("#addcat").click(function() {
        $("#add_admin_form").get(0).reset();
        $(".error").html("");
        $(".text-strong").html("");
    });
    $('#add_admin_form').validate({

        rules: {
            admin_name: {
                required: true,
            },
            admin_email: {
                required: true,
            },
            admin_role: {
                required: true,
            },
            admin_password: {
                required: true,
            }
        },
        messages: {
            admin_name: {
                required: "{{__('lang.This field is required')}}",
            },
            admin_email: {
                required: "{{__('lang.This field is required')}}",
            },
            admin_role: {
                required: "{{__('lang.This field is required')}}",
            },
            admin_password: {
                required: "{{__('lang.This field is required')}}",
            }

        },

        submitHandler: function(form) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.admin-store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        $('#admin_add_modal').modal('hide');
                        swal("{{ __('lang.Done')}}!", data.message, "success");
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
    });
</script>