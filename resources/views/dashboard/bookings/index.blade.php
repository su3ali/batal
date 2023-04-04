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
                                <li class="breadcrumb-item active" aria-current="page">الحجوزات</li>
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

            <div class="col-xl-10 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-right mb-3">

                        <a href="{{route('dashboard.bookings.create')}}" id="" class="btn btn-primary card-tools">
                            {{__('dash.add_new')}}
                        </a>

                    </div>
                    <div class="table-responsive">
                        <table id="html5-extension" class="table table-hover non-hover">
                            <thead>
                            <tr>
                                <th>رقم الحجز</th>
                                <th>رقم الطلب</th>
                                <th>اسم العميل</th>
                                <th>الخدمة المطلوبة</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الفريق الفني</th>
                                <th>حالة الحجز</th>
                                <th>ملاحظات</th>
                                <th class="no-content">{{__('dash.actions')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>


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
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '{{ route('dashboard.bookings.index') }}',
                columns: [
                    {data: 'booking_no', name: 'booking_no'},
                    {data: 'order', name: 'order'},
                    {data: 'customer', name: 'customer'},
                    {data: 'service', name: 'service'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'group', name: 'group'},
                    {data: 'status', name: 'status'},
                    {data: 'notes', name: 'notes'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });

        $(document).on('click', '#edit-booking-status', function () {
            let id = $(this).data('id');
            let name_ar = $(this).data('name_ar');
            let name_en = $(this).data('name_en');
            let description_ar = $(this).data('description_ar');
            let description_en = $(this).data('description_en');
            $('#edit_name_ar').val(name_ar)
            $('#edit_name_en').val(name_en)
            CKEDITOR.instances['edit_description_ar'].setData(description_ar);
            CKEDITOR.instances['edit_description_en'].setData(description_en);

            let action = "{{route('dashboard.booking_statuses.update', 'id')}}";
            action = action.replace('id', id)
            $('#edit_booking_status_form').attr('action', action);

        })

        $("body").on('change', '#customSwitchStatus', function () {
            let active = $(this).is(':checked');
            let id = $(this).attr('data-id');

            $.ajax({
                url: '{{route('dashboard.booking_statuses.change_status')}}',
                type: 'get',
                data: {id: id, active: active},
                success: function (data) {
                    swal({
                        title: "{{__('dash.successful_operation')}}",
                        text: "{{__('dash.request_executed_successfully')}}",
                        type: 'success',
                        padding: '2em'
                    })
                }
            });
        })


    </script>

@endpush
