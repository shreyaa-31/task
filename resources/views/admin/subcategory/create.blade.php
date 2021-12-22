<div class="modal fade" id="subcategory_add_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true" data-backdrop="static" data-keyboard="false" aria-modal="true" aria-labelledby="category_add_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{ __('lang.Add SubCategory') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="POST" enctype="multipart/form-data" id="add_subcategory_form">
                    <div class="form-group">
                        <label>{{ __('lang.Category Name') }} :</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">{{ __('lang.--Select--') }}</option>
                            @foreach ($data as $category)
                            <option value="{{$category->id}}">
                                {{$category->category_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('lang.Sub Category Name') }} :</label>
                        <input type="text" class="form-control" name="subcategory_name" id="subcategory_name" placeholder="{{ __('lang.Type Your SubCategory') }}">                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" value="submit" class="btn btn-primary">{{ __('lang.Add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $("#addsub-cat").click(function(){
 
        $(".error").html("");
        $(".text-strong").html("");
       
    });
    $('#add_subcategory_form').validate({
        rules: {
            category: {
                required: true,
            },
            subcategory_name: {
                required: true,
            }
        },
        messages: {
            category: {
                required: "{{__('lang.This field is required')}}",
            },
            subcategory_name: {
                required: "{{__('lang.This field is required')}}",
            }
        },

        submitHandler: function(form) {
          
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.subcategory.store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        swal("{{__('lang.Done')}}!", data.message, "success");
                        $('#add_subcategory_form').get(0).reset();
                        $("#subcategory_add_modal").modal('hide');
                        $('#subcategory-datatable').DataTable().ajax.reload(); 
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