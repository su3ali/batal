@extends('dashboard.layout.layout')

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
                                <li class="breadcrumb-item active" aria-current="page"> طلبات التقاول والعقود</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

{{--    @include('dashboard.core.services.create')--}}
@endsection


@section('content')


    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-right mb-3">




                    </div>
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الشركه </th>
                            <th>خدمه التقاول</th>
                            <th>اسم المستخدم</th>
                            <th>رقم الموبيل</th>
                            <th>ملاحظات</th>
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
                buttons: {
                    buttons: [
                        {extend: 'copy', className: 'btn btn-sm',text:'نسخ'},
                        {extend: 'csv', className: 'btn btn-sm',text:'تصدير إلى CSV'},
                        {extend: 'excel', className: 'btn btn-sm',text:'تصدير إلى Excel'},
                        {extend: 'print', className: 'btn btn-sm',text:'طباعة'}
                    ]
                },
                "oLanguage": {
                    'sEmptyTable': "{{__('dash.no data available in table')}}",
                    'sInfo': "{{__('dash.Showing')}}" + ' _START_ ' + "{{__('dash.to')}}" + ' _END_ ' + "{{__('dash.of')}}" + ' _TOTAL_ ' + "{{__('dash.entries')}}",
                    'sInfoEmpty': "{{__('dash.Showing')}}" + ' 0 ' + "{{__('dash.to')}}" + ' 0 ' + "{{__('dash.of')}}" + ' 0 ' + "{{__('dash.entries')}}",
                    'sInfoFiltered'  : '('+"{{__('dash.filtered')}}"+' '+"{{__('dash.from')}}"+' _MAX_ '+"{{__('dash.total')}}"+' '+"{{__('dash.entries')}}"+')',
                'sInfoThousands': ',',
                    'sLengthMenu': "{{__('dash.show')}}" + ' _MENU_ ',
                    'sLoadingRecords': "{{__('dash.loading...')}}",
                    'sProcessing': "{{__('dash.processing')}}" + '...',
                    'sSearch': "{{__('dash.search')}}" + ' : ',
                    'sZeroRecords': "{{__('dash.no matching records found')}}",
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                },
                charset: 'UTF-8',
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.core.order_contract.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'service_contract', name: 'service_contract'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'notes', name: 'notes'},
                    {data: 'controll', name: 'controll', orderable: false, searchable: false},

                ]
            });
        });


    </script>


@endpush
