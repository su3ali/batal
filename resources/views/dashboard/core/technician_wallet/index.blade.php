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
                                        href="{{ route('dashboard.home') }}">{{ __('dash.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('dash.technicians wallet') }}
                                </li>
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
                    @if ($wallet)
                        <form action="{{ route('dashboard.core.technician_wallet.update', $wallet->id) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                        @else
                            <form action="{{ route('dashboard.core.technician_wallet.store') }}" method="post"
                                class="form-horizontal" enctype="multipart/form-data" id="demo-form"
                                data-parsley-validate="">
                    @endif
                    @csrf
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{ __('dash.name_ar') }}</label>
                                <input type="text" name="name_ar" value="{{ $wallet->name_ar ?? '' }}"
                                    class="form-control" id="inputEmail4" placeholder="{{ __('dash.name_ar') }}">
                                @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{ __('dash.name_en') }}</label>
                                <input type="text" name="name_en" value="{{ $wallet->name_en ?? '' }}"
                                    class="form-control" id="inputEmail4" placeholder="{{ __('dash.name_en') }}">
                                @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>


                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{ __('dash.point type') }}</label>
                                <select id="inputState" class="select2 form-control pt-1" name="point_type">
                                    <option disabled>{{ __('dash.choose') }}</option>
                                    @if ($wallet && $wallet->point_type)
                                        <option value="rate" @if ($wallet->point_type == 'perc') selected @endif>
                                            {{ __('dash.percentage') }}</option>
                                        <option value="fixed" @if ($wallet->point_type == 'fixed') selected @endif>
                                            {{ __('dash.fixed_value') }}</option>
                                    @else
                                        <option value="rate">{{ __('dash.percentage') }}</option>
                                        <option value="fixed">{{ __('dash.fixed_value') }}</option>
                                    @endif
                                </select>
                                @error('point_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{ __('dash.amount or percentage') }}</label>
                                <input type="text" name="price" value="{{ $wallet->price ?? 0 }}" class="form-control"
                                    id="inputEmail4" placeholder="{{ __('dash.amount or percentage') }}">
                                @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>


                        <div class="form-group col-md-6">
                            <label for="inputEmail4">{{ __('dash.Calculation method') }}</label>
                            <select id="inputState" class="select2 form-control pt-1" name="calculation_method">
                                <option disabled>{{ __('dash.choose') }}</option>
                                @if ($wallet && $wallet->calculation_method)
                                    {{--                                                    <option value="bill" @if ($wallet->calculation_method == 'bill') selected @endif>{{__('dash.bill')}}</option> --}}
                                    <option value="service" @if ($wallet->calculation_method == 'service') selected @endif>
                                        {{ __('dash.service') }}</option>
                                @else
                                    {{--                                                    <option value="bill">{{__('dash.bill')}}</option> --}}
                                    <option value="service">{{ __('dash.service') }}</option>
                                @endif
                            </select>
                            @error('calculation_method')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>




                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('dash.save') }}</button>
                    </form>


                </div>
            </div>

        </div>

    </div>
@endsection
