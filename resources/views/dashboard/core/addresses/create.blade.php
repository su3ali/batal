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
                                        href="{{route('dashboard.core.address.index','id='.request('id'))}}">{{__('dash.user addresses')}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.create')}}</li>
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
                    <form  method="post"
                           action="{{route('dashboard.core.address.store')}}"
                           enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{request('id')}}">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.country')}}</label>
                                <select id="inputState"  class="select2 country_id form-control pt-1"
                                        name="country_id">
                                    <option disabled selected>{{__('dash.choose')}}</option>
                                    @foreach($countries as $key => $country)
                                        <option value="{{$key}}">{{$country}}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.city')}}</label>
                                <select id="inputState" class="select2 city_id form-control pt-1"
                                        name="city_id">
                                    <option disabled>{{__('dash.choose')}}</option>

                                </select>
                                @error('city_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>


                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.region')}}</label>
                                <select id="inputState"  class="select2 region_id form-control pt-1"
                                        name="region_id">
                                    <option disabled>{{__('dash.choose')}}</option>

                                </select>
                                @error('region_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.address')}}</label>
                                <input type="text" name="address" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.address')}}">
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group col-md-3">
                            <button type="submit"
                                    class="btn btn-primary col-md-3">{{__('dash.submit')}}</button>
                        </div>
                    </form>
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
                        $('.region_id').append('<option disabled selected>{{__('dash.choose')}}</option>')
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
