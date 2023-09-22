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
                                        href="{{route('dashboard.core.administration.admins.index')}}">{{__('dash.Admins')}}</a>
                                </li>
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

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form  method="post"
                           action="{{isset($model)?route('dashboard.core.administration.admins.update', $model) : route('dashboard.core.administration.admins.store')}}"
                           enctype="multipart/form-data">
                        @csrf

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.first name')}}</label>
                                <input type="text" name="first_name" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.first name')}}"
                                       value="{{isset($model)?$model->first_name : ''}}">
                                @error('first_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.last name')}}</label>
                                <input type="text" name="last_name" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.last name')}}"
                                       value="{{isset($model)?$model->last_name : ''}}">
                                @error('last_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{--<div class="form-group col-md-6">--}}
                            {{--<label for="inputEmail4">{{__('dash.gender')}}</label>--}}
                            {{--<select id="inputState" class="form-control py-0" name="gender">--}}
                            {{--<option disabled selected>{{__('dash.choose_type')}}</option>--}}
                            {{--<option--}}
                            {{--{{isset($model)?$model->gender == 'male'? 'selected' : '':''}} value="male">{{__('dash.male')}}</option>--}}
                            {{--<option--}}
                            {{--{{isset($model)?$model->gender == 'female'? 'selected' : '':''}} value="female">{{__('dash.female')}}</option>--}}
                            {{--</select>--}}
                            {{--@error('gender')--}}
                            {{--<div class="alert alert-danger">{{ $message }}</div>--}}
                            {{--@enderror--}}
                            {{--</div>--}}
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
                        <div class="form-row mb-3">

                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.roles')}}</label>
                                <select id="inputState" class="select2 form-control"
                                        multiple="multiple"
                                        name="roles[]">
                                    <option disabled>{{__('dash.choose')}}</option>
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
