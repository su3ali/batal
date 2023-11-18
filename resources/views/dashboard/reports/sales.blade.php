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
                                        href="{{ route('dashboard.home') }}">{{ __('dash.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تقرير المبيعات</li>
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
                    <div class="col-md-12  mb-3">
                        <div class="row">
                            <div class="col-md-1">
                                <label for="inputEmail4">{{ __('dash.date') }}</label>
                            </div>
                            <label>من</label>
                            <div class="col-md-4">
                                <input type="datetime-local" name="date" class="form-control date" step="1"
                                    id="inputEmail4">
                            </div>
                            <label>إلى</label>
                            <div class="col-md-4">
                                <input type="datetime-local" name="date2" class="form-control date2" step="1"
                                    id="inputEmail42">
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-md-1">
                                <label for="inputEmail4">طريقه الدفع</label>
                            </div>
                            <div class="col-md-4">
                                <select class="select2 payment_method form-control" name="payment_method">
                                    <option selected value="all">الكل</option>
                                    <option value="cache">شبكة</option>
                                    <option value="wallet">محفظة</option>
                                    <option value="visa">فيزا</option>
                                </select>
                            </div>
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-1">
                                <label for="inputEmail4">الخدمة</label>
                            </div>
                            <div class="col-md-4">
                                <select class="select2 service_filter form-control" name="service_filter">
                                    <option value="all" selected>الكل</option>
                                    @foreach ($services as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>اسم العميل</th>
                                <th>التاريخ</th>
                                <th>الخدمة</th>
                                <th>عدد الخدمات</th>
                                <th>المبلغ</th>
                                <th>طريقة الدفع</th>
                            </tr>
                        </thead>
                    </table>


                </div>

                <table class="table table-bordered nowrap">

                    <thead>
                        <tr>
                            <th width="50%">إجمالي المبيعات بدون ضريبة</th>
                            <td id="total">0</td>
                        </tr>

                        <tr>
                            <th>إجمالي الضريبة %15</th>
                            <td id="tax">0</td>
                        </tr>

                        <tr>
                            <th>إجمالي المبيعات</th>
                            <td id="tax_total">0</td>
                        </tr>

                    </thead>

                </table><!-- end of table -->
            </div>

        </div>

    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            updateSummary();
            var table = $('#html5-extension').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [
                    [0, 'desc']
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
                ajax: '{{ route('dashboard.report.sales') }}',
                columns: [{
                        data: 'order_number',
                        name: 'order_number',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'service',
                        name: 'service',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'service_number',
                        name: 'service_number',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        orderable: true,
                        searchable: true
                    },


                ]
            });

            function updateTableData() {
                var date = $('.date').val();
                var date2 = $('.date2').val();
                var payment_method = $('.payment_method').val();
                var service_filter = $('.service_filter').val();
                var url = '{{ route('dashboard.report.sales') }}';

                if (date) {
                    url += '?date=' + date;
                }
                if (date2) {
                    url += (date ? '&' : '?') + 'date2=' + date2;
                }
                if (payment_method && payment_method !== 'all') {
                    url += (date ? '&' : date2 ? '&' : '?') + 'payment_method=' + payment_method;
                }

                if (service_filter && service_filter !== 'all') {
                    url += (date ? '&' : date2 ? '&' : payment_method ? '&' : '?') + 'service=' + service_filter;
                }

                // Update table data
                table.ajax.url(url).load();

                // Update summary
                updateSummary();

            }

            function updateSummary() {

                $.ajax({
                    url: '{{ route('dashboard.report.updateSummary') }}',
                    type: 'GET',
                    data: {
                        date: $('.date').val(),
                        date2: $('.date2').val(),
                        payment_method: $('.payment_method').val(),
                        service: $('.service_filter').val(),
                    },
                    success: function(data) {

                        $('#total').text(data.total.toFixed(2));
                        $('#tax').text(data.tax.toFixed(2));
                        $('#tax_total').text(data.taxTotal.toFixed(2));
                    }
                });
            }

            // Attach event handlers
            $('.date, .date2, .payment_method, .service_filter').change(function() {
                updateTableData();
            });

            // Call the initial update
            //  updateTableData();
        });
    </script>
@endpush
