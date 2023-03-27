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
                $(".check-all-homesections").click(function () {
                    let boxes = $('.perm-check-homesections');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
                $(".check-all-profile").click(function () {
                    let boxes = $('.perm-check-profile');
                    boxes.prop('checked', this.checked);
                    let matches = $("input.perm-check:checkbox:not(:checked)");
                    checkViewAll(matches)
                });
            </script>

            <script>
                let secondUpload = new FileUploadWithPreview('mySecondImage')
            </script>
    @endpush
