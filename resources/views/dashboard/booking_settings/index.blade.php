@extends('dashboard.layout.layout')
@push('style')
<style>
    .table > thead > tr > th {
        white-space: pre-wrap!important;
    }
</style>
@endpush


@section('sub-header')
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">المواعيد</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-right mb-3">

                        <a href="{{route('dashboard.booking_setting.create')}}" class="btn btn-primary">{{__('dash.add_new')}}</a>


                    </div>
                    <table id="html5-extension" class="table table-hover non-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الخدمه</th>
                            <th>تاريخ بداية الخدمه</th>
                            <th>تاريخ انتهاء الخدمه</th>
{{--                            <th>عدد الحجوزات المتوفره</th>--}}
                            <th>وقت بدايه الخدمه</th>
                            <th>وقت انتهاء الخدمه</th>
                            <th>مده الخدمه</th>
                            <th>الفاصل الزمني</th>
                            <th class="no-content">{{__('dash.actions')}}</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>

        </div>


    </div>
@endsection

@push('script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#html5-extension').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [[0, 'desc']],
                "language": {
                    "url": "{{app()->getLocale() == 'ar'? '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json' : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json'}}"
                },
                buttons: {
                    buttons: [
                        {extend: 'copy', className: 'btn btn-sm'},
                        {extend: 'csv', className: 'btn btn-sm'},
                        {extend: 'excel', className: 'btn btn-sm'},
                        {extend: 'print', className: 'btn btn-sm'}
                    ]
                },
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{{ route('dashboard.booking_setting.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'service_name', name: 'service_name'},
                    {data: 'service_start_date', name: 'service_start_date'},
                    {data: 'service_end_date', name: 'service_end_date'},
                    // {data: 'available_service', name: 'available_service'},
                    {data: 'service_start_time', name: 'service_start_time'},
                    {data: 'service_end_time', name: 'service_end_time'},
                    {data: 'service_duration', name: 'service_duration'},
                    {data: 'buffering_time', name: 'buffering_time'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });




    </script>

@endpush
