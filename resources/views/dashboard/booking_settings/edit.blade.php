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

                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.booking_setting.index')}}">اعدادات الحجوزات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل اعدادات الحجوزات</li>
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
                <div class="widget-content widget-content-area br-6" style="min-height: 500px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>تعديل اعدادات الحجوزات</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.booking_setting.update', $bookingSetting->id)}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="" data-parsley-validate="">
                            {!! method_field('PUT') !!}
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-4">

                                        <label for="service">الخدمة</label>
                                        <select required class="select2 form-control pt-1"
                                                name="service_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}" @if($bookingSetting->service_id == $service->id) selected @endif>{{$service->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="service">تاريخ بدايه الخدمه</label>
                                        <select required class="select2 form-control pt-1"
                                                name="service_start_date">
                                            <option @if($bookingSetting->service_start_date == null) selected @endif disabled>{{__('dash.choose')}}</option>
                                            <option value="Saturday" @if($bookingSetting->service_start_date == 'Saturday') selected @endif >السبت</option>
                                            <option value="Sunday" @if($bookingSetting->service_start_date == 'Sunday') selected @endif>الأحد</option>
                                            <option value="Monday" @if($bookingSetting->service_start_date == 'Monday') selected @endif>الإثنين</option>
                                            <option value="Tuesday" @if($bookingSetting->service_start_date == 'Tuesday') selected @endif>الثلاثاء</option>
                                            <option value="Wednesday" @if($bookingSetting->service_start_date == 'Wednesday') selected @endif>الأربعاء</option>
                                            <option value="Thursday" @if($bookingSetting->service_start_date == 'Thursday') selected @endif>الخميس</option>
                                            <option value="Friday" @if($bookingSetting->service_start_date == 'Friday') selected @endif>الجمعه</option>
                                        </select>
                                        @error('service_start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="service">تاريخ انتهاء الخدمه</label>
                                        <select required class="select2 form-control pt-1"
                                                name="service_end_date">
                                            <option @if($bookingSetting->service_end_date == null) selected @endif disabled>{{__('dash.choose')}}</option>
                                            <option value="Saturday" @if($bookingSetting->service_end_date == 'Saturday') selected @endif >السبت</option>
                                            <option value="Sunday" @if($bookingSetting->service_end_date == 'Sunday') selected @endif>الأحد</option>
                                            <option value="Monday" @if($bookingSetting->service_end_date == 'Monday') selected @endif>الإثنين</option>
                                            <option value="Tuesday" @if($bookingSetting->service_end_date == 'Tuesday') selected @endif>الثلاثاء</option>
                                            <option value="Wednesday" @if($bookingSetting->service_end_date == 'Wednesday') selected @endif>الأربعاء</option>
                                            <option value="Thursday" @if($bookingSetting->service_end_date == 'Thursday') selected @endif>الخميس</option>
                                            <option value="Friday" @if($bookingSetting->service_end_date == 'Friday') selected @endif>الجمعه</option>
                                        </select>
                                        @error('service_end_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                                <div class="form-row mb-3">

{{--                                    <div class="form-group col-md-4">--}}

{{--                                        <label for="birth">عدد الحجوزات المتوفره</label>--}}
{{--                                        <input required name="available_service" type="number" value="{{$bookingSetting->available_service}}" class="form-control">--}}
{{--                                        @error('available_service')--}}
{{--                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}

{{--                                    </div>--}}


                                    <div class="form-group col-md-4">

                                        <label for="inputEmail4">{{__('dash.city')}}</label>
                                        <select id="inputState" class="select2 city_id form-control pt-1"
                                                name="city_id">
                                            <option disabled>{{__('dash.choose')}}</option>
                                            @foreach($cities as $key => $city)
                                                <option value="{{$key}}" @if($key == $bookingSetting->city_id) selected @endif>{{$city}}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="region_id">المناطق</label>
                                        <select required multiple class="region_id select2 form-control pt-1"
                                                name="region_id[]">
                                            <option disabled>{{__('dash.choose')}}</option>
                                            @foreach($regions as $region)
                                                <option value="{{$region->id}}" @if(in_array($region->id, $bookingSetting->regions->pluck('region_id')->toArray())) selected @endif>{{$region->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('region_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <div class="form-group col-md-4">

                                        <label for="birth">وقت بدء الخدمة</label>
                                        <input required name="service_start_time" type="time" value="{{$bookingSetting->service_start_time}}" class="form-control "
                                               data-date-format="h:i">
                                        @error('service_start_time')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>




                                </div>

                                <div class="form-row mb-3">

                                    <div class="form-group col-md-4">

                                        <label for="birth">وقت انتهاء الخدمة</label>
                                        <input required name="service_end_time" type="time" value="{{$bookingSetting->service_end_time}}" class="form-control "
                                               data-date-format="h:i">
                                        @error('service_end_time')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="birth">مدة الخدمة</label>
                                        <input required name="service_duration" value="{{$bookingSetting->service_duration}}" type="text" class="form-control">
                                        @error('service_duration')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <div class="form-group col-md-4">

                                        <label for="service">فاصل زمني</label>
                                        <select required class="select2 form-control pt-1"
                                                name="buffering_time">
                                            <option @if($bookingSetting->buffering_time == null) selected @endif disabled>{{__('dash.choose')}}</option>
                                            <option value="10" @if($bookingSetting->buffering_time == 0) selected @endif>0 minutes</option>
                                            <option value="10" @if($bookingSetting->buffering_time == 10) selected @endif>10 minutes</option>
                                            <option value="20" @if($bookingSetting->buffering_time == 20) selected @endif>20 minutes</option>
                                            <option value="30" @if($bookingSetting->buffering_time == 30) selected @endif>30 minutes</option>
                                            <option value="40" @if($bookingSetting->buffering_time == 40) selected @endif>40 minutes</option>
                                            <option value="50" @if($bookingSetting->buffering_time == 50) selected @endif>50 minutes</option>
                                            <option value="60" @if($bookingSetting->buffering_time == 60) selected @endif>60 minutes</option>
                                        </select>
                                        @error('buffering_time')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            <div class="box-body">
                                <div class="form-row mb-3">

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
    <script>

        $('.select2').select2({
            tags: true,
            dir: '{{app()->getLocale() == "ar"? "rtl" : "ltr"}}'
        })

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
