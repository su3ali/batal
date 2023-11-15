@extends('dashboard.layout.layout')

@section('sub-header')
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.home') }}">{{ __('dash.dashboard') }}</a></li>
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

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row widget-statistic">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.core.customer.index') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-followers">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-users">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $customers }}</p>
                                            <h5 class="">العملاء</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.orders.index') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-referral">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shopping-cart">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $client_orders }}</p>
                                            <h5 class="">{{ __('dash.client_orders') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.core.technician.index') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $technicians }}</p>
                                            <h5 class="">الفنيين</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.visits.index') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-book">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $tech_visits }}</p>
                                            <h5 class="">{{ __('dash.tech_orders') }}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row widget-statistic">

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.order.canceledOrders') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-book">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $canceled_orders }}</p>
                                            <h5 class="">{{ __('dash.canceled_orders') }}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.order.canceledOrdersToday') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-book">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $canceled_orders_today }}</p>
                                            <h5 class="">{{ __('dash.canceled_orders_today') }}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.order.ordersToday') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-referral">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shopping-cart">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $client_orders_today }}</p>
                                            <h5 class="">{{ __('dash.client_orders_today') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <a href="{{ route('dashboard.visits.visitsToday') }}" class="widget-link">
                            <div class="widget widget-one_hybrid widget-engagement">
                                <div class="widget-heading">
                                    <div class="w-title">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-book">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="">
                                            <p class="w-value">{{ $tech_visits_today }}</p>
                                            <h5 class="">{{ __('dash.tech_orders_today') }}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-12 col-sm-12  layout-spacing">

                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-left mb-3">


                        <h5 class="">{{ __('dash.bookings_today') }}</h5>


                    </div>
                    <table id="html5-extension-bookings" class="table table-hover non-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الحجز</th>
                                <th>اسم العميل</th>
                                <th>هاتف العميل</th>
                                <th>الخدمات</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                    </table>


                </div>

            </div>

            <div class="col-xl-6 col-lg-12 col-sm-12  layout-spacing">

                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-left mb-3">


                        <h5 class="">{{ __('dash.client_orders_today') }}</h5>


                    </div>
                    <table id="html5-extension-order" class="table table-hover non-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الطلب</th>
                                <th>اسم العميل</th>
                                <th>التاريخ</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                    </table>


                </div>

            </div>

            <div class="col-xl-6 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-left mb-3">

                        <h5 class="">{{ __('dash.tech_orders_today') }}</h5>


                    </div>
                    <table id="html5-extension" class="table table-hover non-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الطلب</th>
                                <th>الفريق</th>
                                <th>موعد الحجز</th>
                                <th>وقت البدء</th>
                                {{-- <th>وقت الانتهاء</th> --}}
                                <th>الحاله</th>
                            </tr>
                        </thead>
                    </table>


                </div>
            </div>

        </div>
        <!-- sales chart start -->
        <div class="row">
            <div class="col-sm-12">

                @component('components.widget', [
                    'class' => 'box-primary',
                    'title' => __('dash.sells_last_7_days_month'),
                    'id' => 'chartToggleWidget',
                ])
                    <div id="sellsChart1">{!! $sells_chart_1->container() !!}</div>
                    <div id="sellsChart2" style="display: none;">{!! $sells_chart_2->container() !!}</div>
                @endcomponent
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Initial state: show chart 1 and hide chart 2
            $('#sellsChart1').show();
            $('#sellsChart2').hide();


            $('#chartToggleWidget .box-title').click(function() {
                // Toggle the visibility of the charts
                $('#sellsChart1').toggle();
                $('#sellsChart2').toggle();
            });
        });
        $(document).ready(function() {
            var table;
            table = $('#html5-extension-bookings').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [
                    [0, 'asc']
                ],
                "language": {
                    "url": "{{ app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json' : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json' }}"
                },
                buttons: {
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-sm',
                            text: 'نسخ'
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى CSV'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى Excel'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm',
                            text: 'طباعة'
                        }
                    ]
                },
                processing: true,
                responsive: true,
                serverSide: false,
                ajax: {
                    url: '{{ url('admin/bookings?type=service') }}',
                    data: function(d) {
                        d.page = "home";
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'service',
                        name: 'service'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });

        });
        $(document).ready(function() {
            var table;
            table = $('#html5-extension').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [
                    [0, 'asc']
                ],
                "language": {
                    "url": "{{ app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json' : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json' }}"
                },
                buttons: {
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-sm',
                            text: 'نسخ'
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى CSV'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى Excel'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm',
                            text: 'طباعة'
                        }
                    ]
                },
                processing: true,
                responsive: true,
                serverSide: false,
                ajax: {
                    url: '{{ route('dashboard.visits.index') }}',
                    data: function(d) {
                        d.page = "home";
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'group_name',
                        name: 'group_name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    // {data: 'end_time', name: 'end_time'},
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });
            $('#html5-extension tbody').on('click', 'tr', function() {
                var data = table.row(this).data();
                // alert(data.id);
                window.location.href = '/admin/visits/' + data.id;
            });
        });


        $(document).ready(function() {
            var table;
            table = $('#html5-extension-order').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [
                    [0, 'asc']
                ],
                "language": {
                    "url": "{{ app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json' : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json' }}"
                },
                buttons: {
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-sm',
                            text: 'نسخ'
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى CSV'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-sm',
                            text: 'تصدير إلى Excel'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm',
                            text: 'طباعة'
                        }
                    ]
                },
                processing: true,
                serverSide: false,
                responsive: true,
                ajax: {
                    url: '{{ route('dashboard.orders.index') }}',
                    data: function(d) {
                        d.page = "home";
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',

                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });
            $('#html5-extension-order tbody').on('click', 'tr', function() {
                var data = table.row(this).data();
                // alert(data.id);
                window.location.href = '/admin/order/orderDetail?id=' + data.id;
            });
        });
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>


    {!! $sells_chart_1->script() !!}
    {!! $sells_chart_2->script() !!}
@endpush
