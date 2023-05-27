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
                                        href="{{route('dashboard.coupons.index')}}">الكوبونات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">إنشاء كوبون</li>
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
                        <h3>إنشاء كوبون جديد</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.coupons.store')}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="create_order_status_form" data-parsley-validate="">
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-4">
                                        <label for="title_ar">العنوان باللغة العربية</label>
                                        <input type="text" name="title_ar" class="form-control"
                                               id="title_ar"
                                               placeholder="أدخل العنوان"
                                               required
                                        >
                                        @error('title_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="title_en">العنوان باللغة الإنجليزية</label>
                                        <input type="text" name="title_en" class="form-control"
                                               id="title_en"
                                               placeholder="أدخل العنوان"
                                               required
                                        >
                                        @error('title_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 custom-file-container form-group"
                                         data-upload-id="mySecondImage">
                                        <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                                       class="custom-file-container__image-clear"
                                                                       title="Clear Image">x</a></label>
                                        <div style="display: flex">
                                            <label class="custom-file-container__custom-file">
                                                <input required type="file"
                                                       class="custom-file-container__custom-file__custom-file-input"
                                                       name="image"
                                                >
                                                {{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
                                                <span
                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>

                                            <div class=" col-md-2 custom-file-container__image-preview"></div>
                                        </div>
                                    </div>



                                </div> {{-- title --}}

                                <div class="form-row mb-0 pb-0">
                                    <div class="form-group mb-0 col-md-4 pt-1">
                                        <label for=""
                                               style="padding-left: 14px; padding-right: 14px">نطاق الخصم : </label>
                                        <div class="" style="width: 100%; padding-left: 14px; padding-right: 14px">
                                            <label class="radio-inline px-1">
                                                <input class="mx-1" value="all" type="radio" name="sale_area"
                                                       id="all_value"
                                                       checked><span>الكل</span>
                                            </label>
                                            <label class="radio-inline px-1">
                                                <input class="mx-1" value="category" type="radio" name="sale_area"
                                                       id="category_value"><span>قسم</span>
                                            </label>
                                            <label class="radio-inline px-1">
                                                <input class="mx-1" value="service" type="radio" name="sale_area"
                                                       id="service_value"><span>خدمة</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="category_id">القسم</label>
                                        <select id="category_id" disabled class="select2 form-control pt-1"
                                                name="category_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-4">

                                        <label for="service_id">الخدمة</label>
                                        <select id="service_id" disabled class="select2 form-control pt-1"
                                                name="service_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="form-group col-md-3">
                                        <label for="type">النوع</label>
                                        <select required class="form-control" style="width: 100%; padding: 8px"
                                                name="type">
                                            <option value="percentage" selected>نسبة</option>
                                            <option value="static">مبلغ ثابت</option>
                                        </select>
                                        @error('type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="value">القيمة</label>
                                        <input type="number" step="0.1" name="value" class="form-control"
                                               id="value"
                                               placeholder="أدخل القيمة"
                                               required
                                        >
                                        @error('value')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-3">

                                        <label for="birth">تاريخ التفعيل</label>
                                        <input required name="start" type="date" class="form-control datepicker"
                                               data-date-format="dd/mm/yyyy">
                                        @error('start')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-3">

                                        <label for="birth">تاريخ الانتهاء</label>
                                        <input required name="end" type="date" class="form-control datepicker"
                                               data-date-format="dd/mm/yyyy">
                                        @error('end')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="times_limit">مرات الاستخدام</label>
                                            <input type="number" name="times_limit" class="form-control"
                                                   id="times_limit"
                                                   placeholder="أدخل العدد"
                                            >
                                            @error('times_limit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="code">الكود (اتركه فارغ للإنشاء التلقائي)</label>
                                            <input type="text" name="code" class="form-control"
                                                   id="code"
                                                   placeholder="أدخل الكود"
                                            >
                                            @error('code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">

                                        <label for="description_ar">الوصف باللغة العربية</label>
                                        <textarea name="description_ar" id="description_ar" class="ckeditor" cols="30"
                                                  rows="10"></textarea>
                                        @error('description_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="description_en">الوصف باللغة الإنجليزية</label>
                                        <textarea name="description_en" id="description_en" class="ckeditor" cols="30"
                                                  rows="10"></textarea>
                                        @error('description_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                </div> {{-- description --}}


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
    <script>
        $('input[name=sale_area]').change(function () {
            let val = $(this).val()
            if (val === 'category') {
                $('#category_id').prop('disabled', false)
                $('#category_id').prop('required', true)
                $('#service_id').prop('disabled', true)
                $('#service_id').prop('required', false)
                $('#service_id').val('').trigger('change')

            } else if (val === 'service') {
                $('#category_id').prop('disabled', true)
                $('#category_id').prop('required', false)
                $('#service_id').prop('disabled', false)
                $('#service_id').prop('required', true)
                $('#category_id').val('').trigger('change')

            } else {
                $('#category_id').prop('disabled', true)
                $('#category_id').prop('required', false)
                $('#category_id').val('').trigger('change')

                $('#service_id').prop('disabled', true)
                $('#service_id').prop('required', false)
                $('#service_id').val('').trigger('change')

            }
        })
    </script>
    @push('script')
        <script>
            let secondUpload = new FileUploadWithPreview('mySecondImage')

        </script>
    @endpush
@endpush

