<?php
    $name = 'name_'.app()->getLocale();
?>
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
                                <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                <li class="breadcrumb-item" ><a href="{{route('dashboard.core.administration.roles.index')}}">{{__('dash.roles')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{isset($model)? __('dash.edit'):__('dash.create')}}</li>
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
            @if(session()->has('success'))
                <div class="alert alert-success col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post"
                          action="{{isset($model)?route('dashboard.core.administration.roles.update', $model) : route('dashboard.core.administration.roles.store')}}">
                        @csrf
                        @if(!isset($model) || !in_array($model->name, ['super', 'admin']))
                            <x-forms.input :type="'text'" :value="isset($model)?$model->name : ''"
                                           :name="'name'" :class="'form-control'" :label="__('dash.name')"/>
                        @endif
                        <div class="form-row mb-3">
                            <div class="form-group col-md-12">
                                <label for="inputState">{{__('dash.permissions')}}</label>
                                <label
                                    class="new-control new-checkbox new-checkbox-text checkbox-success mx-5">
                                    <input
                                        type="checkbox"
                                        class="new-control-input check-all"
                                    >
                                    <span class="new-control-indicator"></span><span
                                        class="new-chk-content">{{__('dash.check_all')}}</span>
                                </label>

                                <div class="widget-content widget-content-area">
                                    <div class="row">
                                        <div class="col-md-12 col-12 row">

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-admins"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>{{__('dash.admins')}}</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[0]->id}}]"
                                                                    class="new-control-input perm-check perm-check-admins"
                                                                    {{isset($model)? in_array($permissions[0]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[0]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[2]->id}}]"
                                                                    class="new-control-input perm-check perm-check-admins"
                                                                    {{isset($model)? in_array($permissions[2]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[2]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[2]->id}}]"
                                                                    class="new-control-input perm-check perm-check-admins"
                                                                    {{isset($model)? in_array($permissions[2]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[2]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[3]->id}}]"
                                                                    class="new-control-input perm-check perm-check-admins"
                                                                    {{isset($model)? in_array($permissions[3]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[3]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-roles"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>{{__('dash.roles')}}</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[4]->id}}]"
                                                                    class="new-control-input perm-check perm-check-roles"
                                                                    {{isset($model)? in_array($permissions[4]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[4]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[5]->id}}]"
                                                                    class="new-control-input perm-check perm-check-roles"
                                                                    {{isset($model)? in_array($permissions[5]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[5]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[6]->id}}]"
                                                                    class="new-control-input perm-check perm-check-roles"
                                                                    {{isset($model)? in_array($permissions[6]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[6]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[7]->id}}]"
                                                                    class="new-control-input perm-check perm-check-roles"
                                                                    {{isset($model)? in_array($permissions[7]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[7]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-core"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>{{__('dash.core')}}</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[8]->id}}]"
                                                                    class="new-control-input perm-check perm-check-core"
                                                                    {{isset($model)? in_array($permissions[8]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[8]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[9]->id}}]"
                                                                    class="new-control-input perm-check perm-check-core"
                                                                    {{isset($model)? in_array($permissions[9]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[9]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[10]->id}}]"
                                                                    class="new-control-input perm-check perm-check-core"
                                                                    {{isset($model)? in_array($permissions[10]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[10]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-visits"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الزيارات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[12]->id}}]"
                                                                    class="new-control-input perm-check perm-check-visits"
                                                                    {{isset($model)? in_array($permissions[12]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[12]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[13]->id}}]"
                                                                    class="new-control-input perm-check perm-check-visits"
                                                                    {{isset($model)? in_array($permissions[13]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[13]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[14]->id}}]"
                                                                    class="new-control-input perm-check perm-check-visits"
                                                                    {{isset($model)? in_array($permissions[14]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[14]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[15]->id}}]"
                                                                    class="new-control-input perm-check perm-check-visits"
                                                                    {{isset($model)? in_array($permissions[15]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[15]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-packages"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>التقاول</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[17]->id}}]"
                                                                    class="new-control-input perm-check perm-check-packages"
                                                                    {{isset($model)? in_array($permissions[17]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[17]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[18]->id}}]"
                                                                    class="new-control-input perm-check perm-check-packages"
                                                                    {{isset($model)? in_array($permissions[18]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[18]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[19]->id}}]"
                                                                    class="new-control-input perm-check perm-check-packages"
                                                                    {{isset($model)? in_array($permissions[19]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[19]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[20]->id}}]"
                                                                    class="new-control-input perm-check perm-check-packages"
                                                                    {{isset($model)? in_array($permissions[20]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[20]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-orders"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الطلبات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[22]->id}}]"
                                                                    class="new-control-input perm-check perm-check-orders"
                                                                    {{isset($model)? in_array($permissions[22]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[22]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[23]->id}}]"
                                                                    class="new-control-input perm-check perm-check-orders"
                                                                    {{isset($model)? in_array($permissions[23]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[23]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[24]->id}}]"
                                                                    class="new-control-input perm-check perm-check-orders"
                                                                    {{isset($model)? in_array($permissions[24]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[24]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[25]->id}}]"
                                                                    class="new-control-input perm-check perm-check-orders"
                                                                    {{isset($model)? in_array($permissions[25]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[25]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-bookings"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الحجوزات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[27]->id}}]"
                                                                    class="new-control-input perm-check perm-check-bookings"
                                                                    {{isset($model)? in_array($permissions[27]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[27]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[28]->id}}]"
                                                                    class="new-control-input perm-check perm-check-bookings"
                                                                    {{isset($model)? in_array($permissions[28]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[28]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[29]->id}}]"
                                                                    class="new-control-input perm-check perm-check-bookings"
                                                                    {{isset($model)? in_array($permissions[29]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[29]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[30]->id}}]"
                                                                    class="new-control-input perm-check perm-check-bookings"
                                                                    {{isset($model)? in_array($permissions[30]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[30]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-cats"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الأقسام</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[32]->id}}]"
                                                                    class="new-control-input perm-check perm-check-cats"
                                                                    {{isset($model)? in_array($permissions[32]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[32]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[33]->id}}]"
                                                                    class="new-control-input perm-check perm-check-cats"
                                                                    {{isset($model)? in_array($permissions[33]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[33]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[34]->id}}]"
                                                                    class="new-control-input perm-check perm-check-cats"
                                                                    {{isset($model)? in_array($permissions[34]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[34]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[35]->id}}]"
                                                                    class="new-control-input perm-check perm-check-cats"
                                                                    {{isset($model)? in_array($permissions[35]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[35]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-services"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الحدمات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[37]->id}}]"
                                                                    class="new-control-input perm-check perm-check-services"
                                                                    {{isset($model)? in_array($permissions[37]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[37]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[38]->id}}]"
                                                                    class="new-control-input perm-check perm-check-services"
                                                                    {{isset($model)? in_array($permissions[38]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[38]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[39]->id}}]"
                                                                    class="new-control-input perm-check perm-check-services"
                                                                    {{isset($model)? in_array($permissions[39]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[39]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[40]->id}}]"
                                                                    class="new-control-input perm-check perm-check-services"
                                                                    {{isset($model)? in_array($permissions[40]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[40]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-techs"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الفنيين</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[42]->id}}]"
                                                                    class="new-control-input perm-check perm-check-techs"
                                                                    {{isset($model)? in_array($permissions[42]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[42]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[43]->id}}]"
                                                                    class="new-control-input perm-check perm-check-techs"
                                                                    {{isset($model)? in_array($permissions[43]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[43]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[44]->id}}]"
                                                                    class="new-control-input perm-check perm-check-techs"
                                                                    {{isset($model)? in_array($permissions[44]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[44]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[45]->id}}]"
                                                                    class="new-control-input perm-check perm-check-techs"
                                                                    {{isset($model)? in_array($permissions[45]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[45]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-customers"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>العملاء</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[48]->id}}]"
                                                                    class="new-control-input perm-check perm-check-customers"
                                                                    {{isset($model)? in_array($permissions[48]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[48]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[49]->id}}]"
                                                                    class="new-control-input perm-check perm-check-customers"
                                                                    {{isset($model)? in_array($permissions[49]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[49]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[50]->id}}]"
                                                                    class="new-control-input perm-check perm-check-customers"
                                                                    {{isset($model)? in_array($permissions[50]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[50]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[51]->id}}]"
                                                                    class="new-control-input perm-check perm-check-customers"
                                                                    {{isset($model)? in_array($permissions[51]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[51]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-coupons"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الكوبونات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[54]->id}}]"
                                                                    class="new-control-input perm-check perm-check-coupons"
                                                                    {{isset($model)? in_array($permissions[54]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[54]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[55]->id}}]"
                                                                    class="new-control-input perm-check perm-check-coupons"
                                                                    {{isset($model)? in_array($permissions[55]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[55]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[56]->id}}]"
                                                                    class="new-control-input perm-check perm-check-coupons"
                                                                    {{isset($model)? in_array($permissions[56]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[56]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[57]->id}}]"
                                                                    class="new-control-input perm-check perm-check-coupons"
                                                                    {{isset($model)? in_array($permissions[57]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[57]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-notifications"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>الإشعارات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[60]->id}}]"
                                                                    class="new-control-input perm-check perm-check-notifications"
                                                                    {{isset($model)? in_array($permissions[60]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[60]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[61]->id}}]"
                                                                    class="new-control-input perm-check perm-check-notifications"
                                                                    {{isset($model)? in_array($permissions[61]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[61]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[62]->id}}]"
                                                                    class="new-control-input perm-check perm-check-notifications"
                                                                    {{isset($model)? in_array($permissions[62]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[62]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[63]->id}}]"
                                                                    class="new-control-input perm-check perm-check-notifications"
                                                                    {{isset($model)? in_array($permissions[63]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[63]->$name}}</b></span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-wallets"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>المحافظ</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[46]->id}}]"
                                                                    class="new-control-input perm-check perm-check-wallets"
                                                                    {{isset($model)? in_array($permissions[46]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[46]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card component-card_2 col-md-12 px-0">
                                                <div class="form-group h-50 mb-0 px-3 pt-2" style="background-color: #0072ff42;">
                                                    <label
                                                        class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                        <input
                                                            type="checkbox"
                                                            class="new-control-input check-all-rates"
                                                        >
                                                        <span class="new-control-indicator"></span><span
                                                            class="new-chk-content text-primary"><b>التقييمات</b></span>
                                                    </label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="n-chk col-md-3 form-row">
                                                            <label
                                                                class="new-control new-checkbox new-checkbox-text checkbox-success">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[{{$permissions[52]->id}}]"
                                                                    class="new-control-input perm-check perm-check-rates"
                                                                    {{isset($model)? in_array($permissions[52]->id, $model->permissions->pluck('id')->toArray())? 'checked' : '': ''}}
                                                                >
                                                                <span
                                                                    class="new-control-indicator"></span><span
                                                                    class="new-chk-content"><b>{{$permissions[52]->$name}}</b></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">{{__('dash.submit')}}</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection


        @push('script')

            <script>
                $(document).ready(function (){
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    let matches_admins = $("input.perm-check-admins:checkbox:not(:checked)");

                    let matches_roles = $("input.perm-check-roles:checkbox:not(:checked)");

                    let matches_core = $("input.perm-check-core:checkbox:not(:checked)");

                    let matches_packages = $("input.perm-check-packages:checkbox:not(:checked)");

                    let matches_homesections = $("input.perm-check-homesections:checkbox:not(:checked)");

                    let matches_profile = $("input.perm-check-profile:checkbox:not(:checked)");

                    checkViewAll(matches)
                    checkViewType(matches_admins, 'admins')
                    checkViewType(matches_roles, 'roles')
                    checkViewType(matches_core, 'core')
                    checkViewType(matches_packages, 'packages')
                    checkViewType(matches_homesections, 'homesections')
                    checkViewType(matches_profile, 'profile')
                })
                $(".perm-check").click(function () {
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".perm-check-admins").click(function () {
                    let matches = $("input.perm-check-admins:checkbox:not(:checked)");
                    checkViewType(matches, 'admins')
                });
                $(".perm-check-roles").click(function () {
                    let matches = $("input.perm-check-roles:checkbox:not(:checked)");
                    checkViewType(matches, 'roles')
                });
                $(".perm-check-core").click(function () {
                    let matches = $("input.perm-check-core:checkbox:not(:checked)");
                    checkViewType(matches, 'core')
                });
                $(".perm-check-packages").click(function () {
                    let matches = $("input.perm-check-packages:checkbox:not(:checked)");
                    checkViewType(matches, 'packages')
                });
                $(".perm-check-homesections").click(function () {
                    let matches = $("input.perm-check-homesections:checkbox:not(:checked)");
                    checkViewType(matches, 'homesections')
                });
                $(".perm-check-profile").click(function () {
                    let matches = $("input.perm-check-profile:checkbox:not(:checked)");
                    checkViewType(matches, 'profile')
                });
                function checkViewAll(boxes) {
                    if (boxes.length > 0) {
                        $(".check-all").prop('checked', false)
                    } else {
                        $(".check-all").prop('checked', true)
                    }
                }
                function checkViewType(boxes, type) {
                    if (boxes.length > 0) {
                        $(".check-all-"+type).prop('checked', false)
                    } else {
                        $(".check-all-"+type).prop('checked', true)
                    }
                }
                $(".check-all").click(function () {
                    let boxes = $('.perm-check');
                    let box_admins = $('.check-all-admins');
                    let box_roles = $('.check-all-roles');
                    let box_packages = $('.check-all-packages');
                    let box_core = $('.check-all-core');
                    let box_homesections = $('.check-all-homesections');
                    let box_profile = $('.check-all-profile');
                    boxes.prop('checked', this.checked);
                    box_admins.prop('checked', this.checked);
                    box_roles.prop('checked', this.checked);
                    box_packages.prop('checked', this.checked);
                    box_core.prop('checked', this.checked);
                    box_homesections.prop('checked', this.checked);
                    box_profile.prop('checked', this.checked);
                });
                $(".check-all-admins").click(function () {
                    let boxes = $('.perm-check-admins');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-roles").click(function () {
                    let boxes = $('.perm-check-roles');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-core").click(function () {
                    let boxes = $('.perm-check-core');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-packages").click(function () {
                    let boxes = $('.perm-check-packages');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-orders").click(function () {
                    let boxes = $('.perm-check-orders');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-visits").click(function () {
                    let boxes = $('.perm-check-visits');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-bookings").click(function () {
                    let boxes = $('.perm-check-bookings');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-cats").click(function () {
                    let boxes = $('.perm-check-cats');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-services").click(function () {
                    let boxes = $('.perm-check-services');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-techs").click(function () {
                    let boxes = $('.perm-check-techs');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-customers").click(function () {
                    let boxes = $('.perm-check-customers');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-coupons").click(function () {
                    let boxes = $('.perm-check-coupons');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-notifications").click(function () {
                    let boxes = $('.perm-check-notifications');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-wallets").click(function () {
                    let boxes = $('.perm-check-wallets');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-rates").click(function () {
                    let boxes = $('.perm-check-rates');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
            </script>

            <script>
                let secondUpload = new FileUploadWithPreview('mySecondImage')
            </script>
    @endpush
