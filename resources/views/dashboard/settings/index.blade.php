@extends('dashboard.layout.layout')
@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                    <div class="user-profile layout-spacing">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <nav class="breadcrumb-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 py-2">
                                        <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{__('dash.settings')}}</li>
                                    </ol>
                                </nav>
                            </div>
                            <form method="post" action="{{route('dashboard.settings')}}">
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
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">{{__('dash.submit')}}</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
