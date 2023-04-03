@extends('dashboard.layout.layout')
@push('style')
    <link href="{{asset(app()->getLocale().'/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush
@section('content')
    <?php $model = auth()->user(); ?>
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
                                            <li class="breadcrumb-item active" aria-current="page">{{__('dash.profile')}}</li>
                                        </ol>
                                    </nav>
                                </div>
                                <form method="post"
                                      action="{{route('dashboard.core.administration.profile.update', $model)}}"
                                      enctype="multipart/form-data"
                                >
                                    @csrf
                                    {!! method_field('PUT') !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">{{__('dash.name')}}</label>
                                                    <input type="text" name="name" class="form-control" id="inputEmail4"
                                                           placeholder="{{__('dash.name')}}"
                                                           value="{{isset($model)?$model->name : ''}}">
                                                    @error('name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">{{__('dash.gender')}}</label>
                                                    <select id="inputState" class="form-control" name="gender">
                                                        <option disabled selected>{{__('dash.choose_type')}}</option>
                                                        <option
                                                            {{isset($model)?$model->gender == 'male'? 'selected' : '':''}} value="male">{{__('dash.male')}}</option>
                                                        <option
                                                            {{isset($model)?$model->gender == 'female'? 'selected' : '':''}} value="female">{{__('dash.female')}}</option>
                                                    </select>
                                                    @error('gender')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-3">
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
                                            <button type="submit" class="btn btn-primary mt-3">{{__('dash.submit')}}</button>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center">

                                            <div class="form-row mb-3 w-50">
                                                <div class="custom-file-container form-group"
                                                     data-upload-id="mySecondImage">
                                                    <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                                                   class="custom-file-container__image-clear"
                                                                                   title="Clear Image">x</a></label>
                                                    <label class="custom-file-container__custom-file">
                                                        <input type="file"
                                                               class="custom-file-container__custom-file__custom-file-input"
                                                               name="avatar"
                                                        >
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                                                        <span
                                                            class="custom-file-container__custom-file__custom-file-control"></span>
                                                    </label>
                                                    <div class="custom-file-container__image-preview"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('script')
            <script src="{{asset(app()->getLocale().'/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
            <script src="{{asset(app()->getLocale().'/plugins/table/datatable/datatables.js')}}"></script>
            <script
                src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
            <script src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
            <script
                src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
            <script
                src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
            <script>
                $('#html5-extension').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    buttons: {
                        buttons: [
                            {extend: 'copy', className: 'btn btn-sm'},
                            {extend: 'csv', className: 'btn btn-sm'},
                            {extend: 'excel', className: 'btn btn-sm'},
                            {extend: 'print', className: 'btn btn-sm'}
                        ]
                    },
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 7
                });
            </script>

            <script>
                let secondUpload = new FileUploadWithPreview('mySecondImage')
            </script>
    @endpush
@endsection
