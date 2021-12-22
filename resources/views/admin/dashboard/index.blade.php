@extends('layouts.master')

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

                            <div class="ajax-msg">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card mini-stat m-b-30">
                                                <div class="p-3 bg-primary text-white">

                                                    <h6 class="text-uppercase mb-0">{{__('lang.Total Users')}}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="border-bottom pb-4">
                                                        <span class="badge badge-success"> </span> <span class="ml-2 text-muted"></span>
                                                    </div>
                                                    <div class="mt-4 text-muted">
                                                        <div class="float-right">
                                                            <p class="m-0"></p>
                                                        </div>
                                                        <h5 class="m-0">{{$user}}<i class="mdi mdi-arrow-up text-success ml-2"></i></h5>

                                                    </div>
                                                </div>
                                                <div class="p-3 bg-primary text-white">

                                                    <h6 class="text-uppercase mb-0">{{__('lang.Total Employee')}}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="border-bottom pb-4">
                                                        <span class="badge badge-success"> </span> <span class="ml-2 text-muted"></span>
                                                    </div>
                                                    <div class="mt-4 text-muted">
                                                        <div class="float-right">
                                                            <p class="m-0"></p>
                                                        </div>
                                                        <h5 class="m-0">{{$emp}}<i class="mdi mdi-arrow-up text-success ml-2"></i></h5>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
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