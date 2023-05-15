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
                                <li class="breadcrumb-item active" aria-current="page">عرض الطلب</li>
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
                    <div class="card">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-md-5">
                                    <h3 class="card-title">تفاصيل الطلب</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-bordered nowrap">

                                <thead>

                                <tr>
                                    <th>رقم الزياره</th>
                                    <td>{{$visits->visite_id}}</td>
                                </tr>
                                <tr>
                                    @if($visits->booking && $visits->booking->type == 'service')
                                    <th>اسم الخدمه</th>
                                    <td>{{$visits->booking?->service?->title}}</td>
                                    @else
                                        <th>اسم الباقه</th>
                                        <td>{{$visits->booking?->package?->name}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>اسم المجموعه الفنيه</th>
                                    <td>{{$visits->group?->name}}</td>
                                </tr>
                                <tr>
                                    <th>موعد الزياره</th>
                                    <td>{{$visits->booking?->date}}</td>
                                </tr>

                                <tr>
                                    <th>تاريخ البدء</th>
                                    <td>{{$visits->start_time}}</td>
                                </tr>

                                <tr>
                                    <th>تاريخ الانتهاء</th>
                                    <td>{{$visits->end_time}}</td>
                                </tr>

                                <tr>
                                    <th>الحاله</th>
                                    <td>{{$visits->status}}</td>
                                </tr>

                                <tr>
                                    <th>الملاحظات</th>
                                    <td>{!! $visits->note !!}</td>
                                </tr>

                                </thead>

                            </table><!-- end of table -->


                        </div>
                        <!-- /.card-body -->
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
                serverSide: true,
                ajax: '{{ route('dashboard.visits.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'visite_id', name: 'visite_id'},
                    {data: 'date', name: 'date'},
                    {data: 'group_name', name: 'group_name'},
                    {data: 'start_time', name: 'start_time'},
                    {data: 'end_time', name: 'end_time'},
                    {data: 'duration', name: 'duration'},
                    {data: 'status', name: 'status'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });

    </script>

@endpush
