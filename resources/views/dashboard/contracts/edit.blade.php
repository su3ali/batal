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
                                        href="{{route('dashboard.contracts.index')}}">التقاول</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل التقاول</li>
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
                        <h3>تعديل التقاول</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.contracts.update', $contract->id)}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="" data-parsley-validate="">
                            {!! method_field('PUT') !!}
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-4">

                                        <label for="birth">اسم التقاول بالعربي</label>
                                        <input required name="name_ar" value="{{$contract->name_ar}}" type="text" class="form-control">
                                        @error('name_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="birth">اسم التقاول بالانجليزي</label>
                                        <input required name="name_en" value="{{$contract->name_en}}" type="text" class="form-control">
                                        @error('name_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="service">الباقه</label>
                                        <select required class="select2 form-control pt-1"
                                                name="package_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($ContractPackages as $key => $ContractPackage)
                                                <option value="{{$key}}" @if($contract->package_id == $key) selected @endif>{{$ContractPackage}}</option>
                                            @endforeach
                                        </select>
                                        @error('package_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>



                                </div>

                                <div class="form-row mb-3">

                                    <div class="form-group col-md-4">

                                        <label for="birth">تاريخ البدء</label>
                                        <input required name="start_date" value="{{$contract->start_date}}" type="date" class="form-control datepicker"
                                               data-date-format="dd/mm/yyyy">
                                        @error('start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <div class="form-group col-md-4">

                                        <label for="birth">تاريخ الانتهاء</label>
                                        <input required name="end_date" type="date" value="{{$contract->end_date}}" class="form-control datepicker"
                                               data-date-format="dd/mm/yyyy">
                                        @error('end_date')
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

