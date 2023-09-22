
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
                                        href="{{route('dashboard.orders.index')}}">الطلبات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل طلب</li>
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
                <div class="widget-content widget-content-area br-6" style="min-height: 400px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>تعديل طلب </h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.orders.update', $order->id)}}" method="post" class="form-horizontal"
                              enctype="multipart/form-data" id="edit_order_form" data-parsley-validate="">
                            @csrf
                            {!! method_field('PUT') !!}
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">

                                        <label for="edit_customer_name">{{__('dash.customer_name')}}</label>
                                        <select required id="edit_customer_name" class="select2 form-control pt-1"
                                                name="user_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="edit_category_id">{{__('dash.category')}}</label>
                                        <select required id="edit_category_id" class="select2 form-control pt-1"
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
                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">

                                        <label for="edit_service_id">{{__('dash.service')}}</label>
                                        <select required id="edit_service_id" class="select2 form-control pt-1"
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

                                    <div class="form-group col-md-6">
                                        <label for="edit_price">{{__('dash.price_value')}}</label>
                                        <input required type="number" step="0.1" name="price" class="form-control"
                                               id="edit_price"
                                               placeholder="{{__('dash.price')}}"
                                        >
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="form-group">
                                        {!! Form::label('edit_payment_method_visa', 'طريقة الدفع') !!}
                                        <div class="">
                                            <label class="radio-inline">
                                                <input class="mx-2" value="visa" type="radio" name="payment_method" id="edit_payment_method_visa" checked>دفع إلكتروني
                                            </label>
                                            <label class="radio-inline">
                                                <input class="mx-2" value="cache" type="radio" name="payment_method" id="edit_payment_method_cache">دفع نقدي
                                            </label>
                                        </div>
                                        @error('payment_method')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-12">
                                        <label for="edit_notes">الملاحظات</label>
                                        <textarea name="notes" id="edit_notes" cols="30" rows="3" class="form-control"></textarea>
                                        @error('notes')
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




