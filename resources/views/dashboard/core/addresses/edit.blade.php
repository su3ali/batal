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
                                        href="{{route('dashboard.core.address.index','id='.$address->user_id)}}">{{__('dash.user addresses')}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.edit')}}</li>
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
                           action="{{route('dashboard.core.address.update',$address->id)}}"
                           enctype="multipart/form-data">
                        {!! method_field('PUT') !!}
                        @csrf
                        <input type="hidden" name="user_id" value="{{$address->user_id}}">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.country')}}</label>
                                <select id="inputState"  class="select2 country_id form-control pt-1"
                                        name="country_id">
                                    <option disabled>{{__('dash.choose')}}</option>
                                    @foreach($countries as $key => $country)
                                        <option value="{{$key}}" @if($key == $address->country_id) selected @endif>{{$country}}</option>
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
                                    @foreach($cities as $key => $city)
                                        <option value="{{$key}}" @if($key == $address->city_id) selected @endif>{{$city}}</option>
                                    @endforeach
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
                                    @foreach($regions as $key => $region)
                                        <option value="{{$key}}" @if($key == $address->region_id) selected @endif>{{$region}}</option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.address')}}</label>
                                <input type="text" name="address" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.address')}}" value="{{$address->address}}">
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
    </script>
@endpush
