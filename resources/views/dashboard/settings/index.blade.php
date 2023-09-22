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
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.settings')}}</li>
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

        <div class="layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post" action="{{route('dashboard.settings')}}"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->site_name_ar" :name="'site_name_ar'" :class="'form-control'" :label="__('dash.site_name_arabic')"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->site_name_en" :name="'site_name_en'" :class="'form-control'" :label="__('dash.site_name_english')"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->google_api_key" :name="'google_api_key'" :class="'form-control'" :label="'google api key'"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->phone" :name="'phone'" :class="'form-control'" :label="__('dash.phone')"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->whats_app" :name="'whats_app'" :class="'form-control'" :label="__('رقم الواتس اب')"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->email" :name="'email'" :class="'form-control'" :label="__('dash.email')"/>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-12 layout-top-spacing">
                                <div class="col-md-12 custom-file-container form-group"
                                     data-upload-id="mySecondImage">
                                    <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                                   class="custom-file-container__image-clear"
                                                                   title="Clear Image">x</a></label>
                                    <div style="display: flex">
                                        <label class="custom-file-container__custom-file">
                                            <input type="file"
                                                   class="custom-file-container__custom-file__custom-file-input"
                                                   name="logo"
                                            >
                                            {{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
                                            <span
                                                class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>

                                        <div class=" col-md-2 custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-3">

                                <label for="birth">وقت بدء الراحه</label>
                                <input required name="resting_start_time" value="{{$settings->resting_start_time}}" type="time" class="form-control "
                                       data-date-format="h:i">
                                @error('resting_start_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-3">

                                <label for="birth">وقت انتهاء الراحه</label>
                                <input required name="resting_end_time" value="{{$settings->resting_end_time}}" type="time" class="form-control "
                                       data-date-format="h:i">
                                @error('resting_end_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-2">
                                <label for="is_quantity"></label>
                                <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                    <label class="mx-5" for="is_resting">تفعيل وقت الراحه</label>
                                    <input type="checkbox" @if($settings->is_resting == 1) checked @endif name="is_resting" id="is_resting">
                                    <span class="slider round"></span>
                                </label>
                                @error('is_resting')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                        </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">

                                <label for="term_ar">الشروط والاحكام العربية</label>
                                <textarea name="term_ar" id="term_ar" class="ckeditor" cols="30"
                                          rows="10">{{$settings->term_ar}}</textarea>
                                @error('term_ar')
                                <div class="alert term_ar-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="term_en">الشروط والاحكام الإنجليزية</label>
                                <textarea name="term_en" id="term_en" class="ckeditor" cols="30"
                                          rows="10">{{$settings->term_en}}</textarea>
                                @error('term_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">

                                <label for="privacy_ar">سياسة الخصوصيه العربية</label>
                                <textarea name="privacy_ar" id="privacy_ar" class="ckeditor" cols="30"
                                          rows="10">{{$settings->privacy_ar}}</textarea>
                                @error('privacy_ar')
                                <div class="alert term_ar-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="privacy_en">سياسة الخصوصيه الإنجليزية</label>
                                <textarea name="privacy_en" id="privacy_en" class="ckeditor" cols="30"
                                          rows="10">{{$settings->privacy_en}}</textarea>
                                @error('privacy_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">{{__('dash.submit')}}</button>

                    </form>

                </div>
            </div>

        </div>

    </div>
@endsection

@push('script')
    <script>
        let secondUpload = new FileUploadWithPreview('mySecondImage')


        $(document).ready( function(){
            var img = '{{$settings->image}}'
            console.log(img)
            if (img != ''){
                $('.custom-file-container__image-preview').css('background-image', 'url("'+img+'")');
            }
        });
    </script>
@endpush
