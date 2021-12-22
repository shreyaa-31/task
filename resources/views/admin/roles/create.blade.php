@extends('layouts.master')



@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('lang.Role') }}</h4>

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

                            <div class="ajax-msg">

                                {!! Form::open(array('route' => 'admin.role-store','method'=>'POST','id' => 'add_role_form')) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>{{__('lang.Name')}}:</strong>
                                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control col-4')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>{{__('lang.Permission') }}:</strong>
                                            <br />
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('lang.Module Name') }}</th>
                                                        <th>{{__('lang.Create') }}</th>
                                                        <th>{{__('lang.Update') }}</th>
                                                        <th>{{__('lang.Delete') }}</th>
                                                        <th>{{__('lang.View') }}</th>
                                                    </tr>
                                                </thead>
                                                @php $n=1; @endphp
                                                @foreach($permission as $value)
                                                @if($n == 1)
                                                <tr>
                                                    <td><b>{{$value->module}}</b></td>
                                                    @endif
                                                    <td>
                                                        <input type="checkbox" class="permision_check" name="permission[]" value="{{$value->id}}"> {{ $value->name }}
                                                    </td>
                                                    @if($n == 4)
                                                </tr>

                                                @php $n=0; @endphp
                                                @endif
                                                @php $n++; @endphp
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" value="submit" name="submit" class="btn btn-primary float right">{{ __('lang.Submit') }}</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>



@endsection
@push('page_scripts')

@endpush

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $('#add_role_form').validate({

        rules: {
            name: {
                required: true,
            },

        },

        messages: {
            name: {
                required: "{{__('lang.This field is required')}}",
            },

        },
        submitHandler: function(form) {
            console.log(form);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{route('admin.role-store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true)

                    {
                        swal("{{__('lang.Done')}}!", data.message, "success");
                        $('#role_add_modal').modal('hide');
                        window.LaravelDataTables["role-table"].draw();
                    }
                }

            });
        }
    })
</script>