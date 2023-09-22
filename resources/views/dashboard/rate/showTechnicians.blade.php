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
                                <li class="breadcrumb-item active" aria-current="page">عرض تقييم الفنيين</li>
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
                                    <h3 class="card-title">تفاصيل تقييم الفني</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-bordered nowrap">

                                <thead>
                                <tr>
                                    <th>اسم العميل</th>
                                    <td>{{$tech->user?->first_name . ' ' . $tech->user?->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>رقم الجوال</th>
                                    <td>{{$tech->user?->phone}}</td>
                                </tr>

                                <tr>
                                    <th>اسم الفني</th>
                                    <td>{{$tech->technician?->name}}</td>
                                </tr>
                                <tr>
                                    <th>رقم الجوال</th>
                                    <td>{{$tech->technician?->phone}}</td>
                                </tr>
                                <tr>
                                    <th>اسم المجموعه</th>
                                    <td>{{$tech->technician?->group?->name}}</td>
                                </tr>

                                <tr>
                                    <th>التخصص</th>
                                    <td>{{$tech->technician?->specialization?->name}}</td>
                                </tr>

                                <tr>
                                    <th>رقم الطلب</th>
                                    <td>{{$tech->order?->id}}</td>
                                </tr>
                                <tr>
                                    <th>اجمالي الطلب</th>
                                    <td>{{$tech->order?->total}}</td>
                                </tr>
                                <tr>
                                    <th>كميه الطلب</th>
                                    <td>{{$tech->order?->quantity}}</td>
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
