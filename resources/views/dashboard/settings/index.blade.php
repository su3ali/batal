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
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->site_name_ar" :name="'site_name_ar'" :class="'form-control'" :label="__('dash.site_name_arabic')"/>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->site_name_en" :name="'site_name_en'" :class="'form-control'" :label="__('dash.site_name_english')"/>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 layout-top-spacing">
                                <x-forms.input :type="'text'" :value="$settings->google_api_key" :name="'google_api_key'" :class="'form-control'" :label="'google api key'"/>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 layout-top-spacing">
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
