@extends('blogs.layouts.master')


@section('content')
<style>
        .error{
            color:red;
        }
    </style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center mt-0 m-b-15">
                                    <a href="" class="logo logo-admin"></a>
                                </h3>

                                <h4 class="text-muted text-center font-18"><b>
                                        Create Blog</b></h4>

                                <div class="p-2">
                                    <form method="post" id="create_blog_form">
                                        @csrf

                                        <div class="form-group">
                                            <label for="firstname">{{ __('Blog Name') }} :</label>
                                            <input id="blogname" type="text" class="form-control" name="blogname" value="{{ old('firstname') }}" placeholder="Name" autofocus>
                                        </div>

                                        @if ($errors->has('firstname'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif

                                        <div class="form-group ">
                                            <label for="category_id">{{ __('Blog Category') }} :</label>
                                            <select class="form-control" name="blogcategory_id" id="blogcategory_id">
                                                <option value="">---Select BlogCategory ----</option>
                                                @foreach ($blog as $category)
                                                <option value="{{$category->id}}">
                                                    {{$category->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('blogcategory_id'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('blogcategory_id') }}</strong>
                                        </span>
                                        @endif


                                        <div class="form-group ">
                                            <label for="email">{{ __('Blog Description') }} :</label>

                                            <textarea id="description" class="form-control" name="description" placeholder="Description" autofocus></textarea>
                                        </div>
                                        @if ($errors->has('description'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                        @endif



                                        <div class="form-group ">
                                            <label for="profile">{{ __('Add Image') }} :</label>
                                            <input id="image" type="file" class="form-control @error('blogimage') is-invalid @enderror" name="image" autocomplete="current-profile">
                                        </div>
                                        <div class="form-group">

                                            <button type="submit" value="submit" name="submit" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                </div>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    </section>

    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        $('#create_blog_form').validate({
            rules: {
                blogname: {
                    required: true,

                },
                description: {
                    required: true,

                },
                image: {
                    required: true,

                },
                blogcategory_id: {
                    required: true,
                }

            },
            messages: {
                blogname: {
                    required: "Enter Your BlogName ",
                },
                description: {
                    required: "Enter Your Blog-Description",
                },
                image: {
                    required: "Add Image",

                },
                blogcategory_id: {
                    required: "Select Appropriate Category",
                }
            },
            submitHandler: function(form) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('blog-create')}}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        swal("Done!", data.message, "success");
                    },
                    error: function(response) {
                        $('.text-strong').text('');
                        $.each(response.responseJSON.errors, function(field_name, error) {
                            $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                        })
                    }

                })
            },

        });
    </script>

@endsection
