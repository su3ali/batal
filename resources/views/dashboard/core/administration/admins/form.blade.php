@extends('dashboard.layout.layout')

@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                    <div class="user-profile layout-spacing">
                        <div class="widget-content widget-content-area">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                                <div class="d-flex justify-content-between">
                                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-3 py-2">
                                            <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                            <li class="breadcrumb-item" ><a href="{{route('dashboard.core.administration.admins.index')}}">{{__('dash.admins')}}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">{{isset($model)? __('dash.edit'):__('dash.create')}}</li>
                                        </ol>
                                    </nav>

                                </div>
                                <form method="post"
                                      action="{{isset($model)?route('dashboard.core.administration.admins.update', $model) : route('dashboard.core.administration.admins.store')}}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-row mb-3">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{__('dash.first name')}}</label>
                                            <input type="text" name="first_name" class="form-control" id="inputEmail4"
                                                   placeholder="{{__('dash.first name')}}"
                                                   value="{{isset($model)?$model->first_name : ''}}">
                                            @error('first_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{__('dash.last name')}}</label>
                                            <input type="text" name="last_name" class="form-control" id="inputEmail4"
                                                   placeholder="{{__('dash.last name')}}"
                                                   value="{{isset($model)?$model->last_name : ''}}">
                                            @error('last_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>


                                    <div class="form-row mb-3">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{__('dash.phone')}}</label>
                                            <input type="text" name="phone" class="form-control"
                                                   id="inputEmail4"
                                                   placeholder="{{__('dash.phone')}}"
                                                   value="{{isset($model)?$model->phone : ''}}">
                                            @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{__('dash.email')}}</label>
                                            <input type="email" name="email" class="form-control"
                                                   id="inputEmail4"
                                                   placeholder="{{__('dash.email')}}"
                                                   value="{{isset($model)?$model->email : ''}}">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-row mb-3">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{__('dash.password')}}</label>
                                            <input type="password" name="password" class="form-control"
                                                   id="inputEmail4"
                                                   placeholder="{{__('dash.password')}}"
                                            >
                                            @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="inputEmail4">{{__('dash.password_confirmation')}}</label>
                                            <input type="password" name="password_confirmation"
                                                   class="form-control"
                                                   id="inputEmail4"
                                                   placeholder="{{__('dash.password_confirmation')}}"
                                            >
                                            @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">

                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">{{__('dash.roles')}}</label>
                                                <select class="form-control select2 tagging" multiple="multiple" name="roles[]">
                                                    <option disabled>{{__('dash.roles')}}</option>
                                                    @foreach($roles as $id => $name)
                                                    <option
                                                        {{isset($model)?in_array($id, $model->roles->pluck('id')->toArray())? 'selected' : '':''}} value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <button type="submit"
                                                class="btn btn-primary col-md-6">{{__('dash.submit')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        let secondUpload = new FileUploadWithPreview('mySecondImage')
    </script>
    @endpush
