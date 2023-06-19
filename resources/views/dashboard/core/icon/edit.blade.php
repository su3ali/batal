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
                                        href="{{route('dashboard.core.icon.index')}}">الايقونات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل ايقونه</li>
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
                        <h3>تعديل ايقونه</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.core.icon.update', $icon->id)}}" method="post"
                              class="form-horizontal"
                              enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                            @csrf
                            {!! method_field('PUT') !!}
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">{{__('dash.title_ar')}}</label>
                                        <input type="text" name="title_ar" class="form-control"
                                               id="inputEmail4" value="{{$icon->title_ar}}"
                                               placeholder="{{__('dash.title_ar')}}"
                                        >
                                        @error('title_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">{{__('dash.title_en')}}</label>
                                        <input type="text" name="title_en" class="form-control"
                                               id="inputEmail4" value="{{$icon->title_en}}"
                                               placeholder="{{__('dash.title_en')}}"
                                        >
                                        @error('title_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>



                                <div class="form-row mb-3">
                                    <div class="col-md-6 custom-file-container form-group"
                                         data-upload-id="myImage">
                                        <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                                       class="custom-file-container__image-clear"
                                                                       title="Clear Image">x</a></label>
                                        <div style="display: flex" class="editImage">
                                            <label class="custom-file-container__custom-file">
                                                <input required type="file"
                                                       class="custom-file-container__custom-file__custom-file-input"
                                                       name="image"
                                                >
                                                {{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
                                                <span
                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>

                                            <div class=" col-md-2 custom-file-container__image-preview"></div>
                                        </div>
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




@push('script')

    <script>

        let myImage = new FileUploadWithPreview('myImage')

        var img = '{{$icon->images}}';
        if (img != ''){
            $('.editImage .custom-file-container__image-preview').css('background-image', 'url("'+img+'")');
        }
    </script>
@endpush
