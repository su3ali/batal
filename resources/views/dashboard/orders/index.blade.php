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
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.orders')}}</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

{{--    @include('dashboard.orders.create')--}}
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-right mb-3">

{{--                        <button type="button" id="" class="btn btn-primary card-tools" data-toggle="modal"--}}
{{--                                data-target="#createOrderModel">--}}
{{--                            {{__('dash.add_new')}}--}}
{{--                        </button>--}}

                        <a href="{{route('dashboard.orders.create')}}" id="" class="btn btn-primary card-tools">
                            {{__('dash.add_new')}}
                        </a>

                    </div>
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('dash.customer_name')}}</th>
                            <th>{{__('dash.category')}}</th>
                            <th>{{__('dash.quantity')}}</th>
                            <th>{{__('dash.price_value')}}</th>
                            <th>{{__('dash.status')}}</th>
                            <th>تاريخ الطلب</th>
                            <th class="no-content">{{__('dash.actions')}}</th>
                        </tr>
                        </thead>
                    </table>


                </div>
            </div>

        </div>

    </div>
{{--    @include('dashboard.orders.edit')--}}
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
                serverSide: true,
                ajax: '{{ route('dashboard.orders.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user', name: 'user'},
                    {data: 'category', name: 'category'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });

        {{--$(document).on('click', '#edit-order', function () {--}}
        {{--    let id = $(this).data('id');--}}
        {{--    let user_id = $(this).data('user_id');--}}
        {{--    let category_id = $(this).data('category_id');--}}
        {{--    let service_id = $(this).data('service_id');--}}
        {{--    let price = $(this).data('price');--}}
        {{--    let payment_method = $(this).data('payment_method');--}}
        {{--    let notes = $(this).data('notes');--}}
        {{--    $('#edit_customer_name').val(user_id).trigger('change')--}}
        {{--    $('#edit_category_id').val(category_id).trigger('change')--}}
        {{--    $('#edit_service_id').val(service_id).trigger('change')--}}
        {{--    $('#edit_price').val(price)--}}
        {{--    $('#edit_notes').html(notes)--}}

        {{--    if (payment_method === 'visa'){--}}
        {{--        $('#edit_payment_method_visa').prop('checked', true)--}}
        {{--        $('#edit_payment_method_cache').prop('checked', false)--}}
        {{--    }else {--}}
        {{--        $('#edit_payment_method_visa').prop('checked', false)--}}
        {{--        $('#edit_payment_method_cache').prop('checked', true)--}}
        {{--    }--}}
        {{--    let action = "{{route('dashboard.orders.update', 'id')}}";--}}
        {{--    action = action.replace('id', id)--}}
        {{--    $('#edit_order_form').attr('action', action);--}}


        {{--})--}}

        $("body").on('change', '#customSwitchtech', function () {
            let active = $(this).is(':checked');
            let id = $(this).attr('data-id');

            $.ajax({
                url: '{{route('dashboard.core.technician.change_status')}}',
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
