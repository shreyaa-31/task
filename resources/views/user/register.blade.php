<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>User Registration</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="images/favicon.ico">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div class="accountbg">
        <div class="content-center">
            <div class="content-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center mt-0 m-b-15">
                                    <a href="" class="logo logo-admin"></a>
                                    </h3>

                                    <h4 class="text-muted text-center font-18"><b>
                                            Register here!</b></h4>

                                    <div class="p-2">
                                        <form method="post" id="register_form">
                                            @csrf

                                            <div class="form-group">
                                                <label for="firstname">{{ __('Firstname') }} :</label>
                                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="Enter Your Firstname" autocomplete="firstname" autofocus>
                                            </div>

                                            @if ($errors->has('firstname'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                            @endif

                                            <div class="form-group ">
                                                <label for="lastname">{{ __('Lastname') }} :</label>
                                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" placeholder="Enter Your Lastname" autocomplete="lastname" autofocus>
                                            </div>
                                            @if ($errors->has('lastname'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                            @endif


                                            <div class="form-group ">
                                                <label for="email">{{ __('Email') }} :</label>

                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Enter Your Email" autofocus>
                                            </div>
                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif

                                            <div class="form-group">
                                                <label for="category">{{ __('Category') }} :</label>
                                                <select class="form-control" name="category_id" id="category_id">
                                                    <option value="">---Select Category ----</option>
                                                    @foreach ($data as $category)
                                                    <option value="{{$category->id}}">
                                                        {{$category->category_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category'))
                                            <span class="invalid-feedback d-block" id="category" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                            @endif


                                            <div class="form-group">
                                                <label for="subcategory">{{ __('Subcategory') }} :</label>
                                                <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                    <option value="">---Select Sub Category ----</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('subcategory_id'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('subcategory_id') }}</strong>
                                            </span>
                                            @endif

                                            <div class="form-group ">
                                                <label for="email">{{ __('Password') }} :</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Your Password" autocomplete="current-password">
                                            </div>
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                            <div class="form-group ">
                                                <label for="profile">{{ __('Profile') }} :</label>
                                                <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror" name="profile" autocomplete="current-profile">
                                            </div>
                                            <div class="form-group">

                                                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            Already have an account!!
                                            <a href="{{route('user.login')}}">Sign here</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
    <script src="{{asset('assets/{{asset{{js/detect.js')}}"></script>
    <script src="{{asset('assets/js/fastclick.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#category_id').on('change', function() {
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
                    $("#subcategory_id").html('<option value="">---Select Sub Category ----</option>');
                    $.each(data.data, function(key, value) {
                        $("#subcategory_id").append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    });
                }
            })

        })
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");


        $('#register_form').validate({
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
                category_id: {
                    required: true,
                },
                subcategory_id: {
                    required: true,
                },
                password: {
                    required: true,
                },
                profile: {
                    required: true,
                },

            },
            messages: {
                firstname: {
                    required: "Enter Your Firstname ",
                },
                lastname: {
                    required: "Enter Your Lastname",
                },
                email: {
                    required: "Enter Your Email",
                    email: "Enter Valid Email-Address",
                },
                category_id: {
                    required: "Select Appropriate Category",
                },
                subcategory_id: {
                    required: "Select Appropriate SubCategory",
                },
                password: {
                    required: "Enter Password",
                },
                profile: {
                    required: "Upload Your Profile",
                },
            },
            submitHandler: function(form) {
               
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('add_user')}}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        swal("Done!", data.message, "success");
                        $('#register_form').get(0).reset();
                        window.location.href = '/user/enterotp/' + data.data.id;

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

</body>

</html>