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
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <a href="{{route('admin.create-role')}}" class="btn btn-success btn-save float-right" title="Add ">{{ __('lang.Add') }} </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="roles-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.No')}}</th>
                                            <th>{{__('lang.Name')}}</th>
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

@endsection

@push('page_scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

        $('#roles-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.roles') }}",
            language: {
                search: "{{__('lang.search')}}",
                processing: "{{__('lang.processing')}}",
                sInfo: "{{__('lang.sInfo')}}",
                sLengthMenu: "{{__('lang.sLengthMenu')}}",
                sInfoFiltered:"{{__('lang.sInfoFiltered')}}",
                sInfoEmpty:"{{__('lang.sInfoEmpty')}}",
                sZeroRecords:   "{{__('lang.sZeroRecords')}}",
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
                    data: 'name',
                    name: "name",
                    searchable: true
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
</script>
@endpush