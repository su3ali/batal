@extends('dashboard.layout.layout')
@push('style')
    <style>
        .card-wallet{
            background-color: #0e1726;
            text-align: center;
            height: 46px;
            line-height: 2.7;
            margin-top: 30px;
        }

        .card-wallet p{
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 0;
        }
    </style>
    @endpush
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
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.customers wallet')}}</li>
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
                                <div class="form-group col-md-5">
                                    <label for="inputEmail4">{{__('dash.name_ar')}}</label>
                                    <input type="text" name="name_ar" value="{{$wallet->name_ar ?? ''}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_ar')}}"
                                    >
                                    @error('name_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="inputEmail4">{{__('dash.name_en')}}</label>
                                    <input type="text" name="name_en" value="{{$wallet->name_en ?? ''}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.name_en')}}"
                                    >
                                    @error('name_en')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="row" style="    margin-top: 22px;">
                                        <label class="mx-3 mt-3 col-md-2" for="status">{{__('dash.status')}}</label>
                                        <label class="switch s-outline s-outline-info mb-4 mx-4 mt-3 d-block col-md-3">
                                            <input type="checkbox" name="active" id="status" @if($wallet && $wallet->active == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>


                            </div>





                            <div class="form-row mb-3">
                                <div class="card col-md-1 card-wallet">
                                    <p >{{__('dash.order')}} /</p>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputEmail4">{{__('dash.deserved percentage')}}</label>
                                    <input type="text" name="order_percentage" value="{{$wallet->order_percentage ?? 0}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.deserved percentage')}}"
                                    >
                                    @error('order_percentage')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{__('dash.Maximum refund amount')}}</label>
                                    <input type="text" name="refund_amount" value="{{$wallet->refund_amount ?? 0}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.Maximum refund amount')}}"
                                    >
                                    @error('refund_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>



                            <div class="form-row mb-3">
                                <div class="card col-md-1 card-wallet" >
                                    <p>{{__('dash.replacing')}} /</p>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputEmail4">{{__('dash.Minimum order amount')}}</label>
                                    <input type="text" name="order_amount" value="{{$wallet->order_amount ?? 0}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.Minimum order amount')}}"
                                    >
                                    @error('order_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label  for="inputEmail4">{{__('dash.Minimum wallet amount')}}</label>
                                    <input type="text" name="wallet_amount" value="{{$wallet->wallet_amount ?? 0}}" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{__('dash.Minimum wallet amount')}}"
                                    >
                                    @error('wallet_amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>








                        </div>
<button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                    </form>


                </div>
            </div>

        </div>

    </div>


@endsection
