
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
                                <li class="breadcrumb-item">
                                    <a
                                                                        href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">الاشعارات</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

    {{--    @include('dashboard.order_statuses.create')--}}
@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6" style="min-height: 500px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>ارسال اشعارات</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.notification.sendNotification')}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="create_order_status_form" data-parsley-validate="">
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">
                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input type" value="customer" checked name="type">
                                                <span class="new-control-indicator"></span>العملاء
                                            </label>
                                        </div>
                                        @error('type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-6">

                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input type" value="technician" name="type">
                                                <span class="new-control-indicator"></span>الفنيين
                                            </label>
                                        </div>
                                        @error('type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <div class="form-group col-md-6 div-customer">
                                        <label for="customer">العملاء</label>
                                        <select  class="form-control customer_id"  style="width: 100%; padding: 8px"
                                                name="customer_id">
                                            <option value="all" selected>الكل</option>
                                            @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->first_name}} - {{ $customer->phone}}</option>
                                                @endforeach
                                        </select>
                                        @error('customer_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6 div-technician" style="display:none;">
                                        <label for="customer">الفنيين</label>
                                        <select  class="form-control technician_id" disabled style="width: 100%; padding: 8px"
                                                name="technician_id">
                                            <option value="all" selected>الكل</option>
                                            @foreach($technicians as $key => $technician)
                                                <option value="{{$key}}">{{$technician}}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="title">العنوان</label>
                                        <input type="text" name="title" class="form-control"
                                               id="title"
                                               placeholder="أدخل العنوان"
                                               required
                                        >
                                        @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">

                                        <label for="message">الرساله</label>
                                        <textarea name="message" id="message" class="ckeditor" cols="30"
                                                  rows="10"></textarea>
                                        @error('message')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>


                            </div>
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="col-md-6">

                                    </div>

                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                                        <button class="btn" data-dismiss="modal"><i
                                                class="flaticon-cancel-12"></i> {{__('dash.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@push('script')

    <script type="text/javascript">
        $("body").on('change', '.type', function () {

            if ($(this).val() == 'technician') {
                $('.div-customer').hide();
                $('.customer_id').attr('disabled',true);
                $('.technician_id').attr('disabled',false);
                $('.div-technician').show();


            } else {
                $('.div-technician').hide();
                $('.customer_id').attr('disabled',false);
                $('.technician_id').attr('disabled',true);
                $('.div-customer').show();

            }

        })


    </script>

@endpush
