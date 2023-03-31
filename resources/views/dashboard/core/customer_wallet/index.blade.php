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
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.services')}}</li>
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
                    @if($wallet)
                    <form action="{{route('dashboard.core.customer_wallet.update',$wallet->id)}}" method="post" class="form-horizontal"
                          enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                        @else
                            <form action="{{route('dashboard.core.customer_wallet.store')}}" method="post" class="form-horizontal"
                                  enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                            @endif
                        @csrf
                        <div class="box-body">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{__('dash.name_ar')}}</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_ar')}}"
                                    >
                                    @error('title_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{__('dash.name_en')}}</label>
                                    <input type="text" name="name_en" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_en')}}"
                                    >
                                    @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{__('dash.order')}}</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_ar')}}"
                                    >
                                    @error('title_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label style="padding: 8px;" for="inputEmail4"></label>
                                    <input type="text" name="name_en" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_en')}}"
                                    >
                                    @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>


                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{__('dash.replacing')}}</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_ar')}}"
                                    >
                                    @error('title_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label style="padding: 8px;" for="inputEmail4"></label>
                                    <input type="text" name="name_en" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_en')}}"
                                    >
                                    @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>



                            <div class="form-group col-md-6">
                                <label class="mx-5" for="status">{{__('dash.status')}}</label>
                                <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                    <input type="checkbox" name="active" id="status" checked>
                                    <span class="slider round"></span>
                                </label>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>




                        </div>

                    </form>


                </div>
            </div>

        </div>

    </div>


@endsection
