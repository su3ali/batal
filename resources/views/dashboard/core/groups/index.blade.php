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
                                <li class="breadcrumb-item active" aria-current="page">مجموعات الفنيين</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

    @include('dashboard.core.groups.create')
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-md-12 text-right mb-3">

                        <button type="button" id="" class="btn btn-primary card-tools" data-toggle="modal"
                                data-target="#groupModal">
                            {{__('dash.add_new')}}
                        </button>

                    </div>
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('dash.name')}}</th>
                            <th>مشرف المجموعة</th>
                            <th>الحاله</th>
                            <th class="no-content">{{__('dash.actions')}}</th>
                        </tr>
                        </thead>
                    </table>


                </div>
            </div>

        </div>

    </div>
    @include('dashboard.core.groups.edit')
@endsection
@push('script')
    <script>
        $(document).ready(function (){
            $('.country_id').on('change',function (){
                var country_id=$(this).val();
                $.ajax({
                    url: '{{route('dashboard.core.address.getCity')}}',
                    data:{country_id:country_id},
                    success: function(response) {
                        $('.city_id').empty()
                        $('.city_id').append('<option disabled selected>{{__('dash.choose')}}</option>')
                        $.each(response, function (i, item) {

                            $('.city_id').append($('<option>', {
                                value: i,
                                text : item
                            }));
                        });

                    }
                });

            });

        });

        $(document).ready(function (){
            $('.city_id').on('change',function (){
                var city_id=$(this).val();
                $.ajax({
                    url: '{{route('dashboard.core.address.getRegion')}}',
                    data:{city_id:city_id},
                    success: function(response) {
                        $('.region_id').empty()
                        $('.region_id').append('<option disabled>{{__('dash.choose')}}</option>')
                        $.each(response, function (i, item) {

                            $('.region_id').append($('<option>', {
                                value: i,
                                text : item
                            }));
                        });

                    }
                });

            });

        });
    </script>
@endpush

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
                        {extend: 'copy', className: 'btn btn-sm',text:'نسخ'},
                        {extend: 'csv', className: 'btn btn-sm',text:'تصدير إلى CSV'},
                        {extend: 'excel', className: 'btn btn-sm',text:'تصدير إلى Excel'},
                        {extend: 'print', className: 'btn btn-sm',text:'طباعة'}
                    ]
                },
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.core.group.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'g_name', name: 'g_name'},
                    {data: 'technician', name: 'technician'},
                    {data: 'status', name: 'status'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });

        $(document).on('click', '#edit-techGroup', function () {
            let id = $(this).data('id');
            let name_en = $(this).data('name_en');
            let name_ar = $(this).data('name_ar');
            let technician_id = $(this).data('technician_id');
            let technician_group_id = $(this).data('technician_group_id');
            let country_id = $(this).data('country_id');

            let city_id = $(this).data('city_id');
            let region_id = $(this).data('region_id');
            $('#edit_name_en').val(name_en)
            $('#edit_name_ar').val(name_ar)
            $('#edit_technician_id').val(technician_id).trigger('change')
            $('#technician_group_id').val(technician_group_id).trigger('change')
            $("#country_id option[value='" + country_id + "']").attr("selected",true);
            $("#city_id option[value='" + city_id + "']").attr("selected",true);
            $('#region_id').val(region_id).trigger('change')
            let action = "{{route('dashboard.core.group.update', 'id')}}";
            action = action.replace('id', id)
            $('#edit_grouptech_form').attr('action', action);

        })


        $("body").on('change', '#customSwitch4', function () {
            let active = $(this).is(':checked');
            let id = $(this).attr('data-id');

            $.ajax({
                url: '{{route('dashboard.core.group.change_status')}}',
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
