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
                                <li class="breadcrumb-item active" aria-current="page">{{ __('dash.view_coupon') }}</li>
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
                                <label for="inputEmail4">الحالة</label>
                            </div>
                            <div class="col-md-4">
                                <select class="select2 usage_filter form-control" name="usage_filter">
                                    <option value="all" selected>الكل</option>
                                    <option value="used">قام بالاستخدام</option>
                                    <option value="notused">لم يستخدم بعد</option>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">



                            <div class="col-md-4">
                                <label >عدد مرات الاستخدام للشخص الواحد:  {{ $coupon->user_times }}</label>
                            </div>
                            <div class="col-md-4">
                                <label >عدد مرات الاستخدام الكلي:  {{ $coupon->times_limit }}</label>
                            </div>
                           

                        </div>
                      
                        


                    </div>
                    <div class="col-md-12 text-right mb-3">


                    </div>
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>

                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>عدد مرات الاستخدام</th>
                                {{-- <th class="no-content">{{ __('dash.actions') }}</th> --}}
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
        $(document).ready(function() {
            var table = $('#html5-extension').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                // order: [
                //     [2, 'desc']
                // ],
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
                ajax: '{{ route('dashboard.coupons.viewSingleCoupon', $id) }}',

                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone',

                    },
                    {
                        data: 'usage',
                        name: 'usage',
                    },
                    // {
                    //     data: 'control',
                    //     name: 'control',
                    //     orderable: false,
                    //     searchable: false
                    // },

                ]
            });
          
            function updateTableData() {
                var usage_filter = $('.usage_filter').val();
                var url = '{{ route('dashboard.coupons.viewSingleCoupon',['id'=>$id]) }}';

                if (usage_filter && usage_filter !== 'all') {
                    url += '&usage=' + usage_filter;
                }

                // Update table data
                table.ajax.url(url).load();

            }
            $('.usage_filter').change(function() {
                updateTableData();
            });
        });
    </script>
@endpush
