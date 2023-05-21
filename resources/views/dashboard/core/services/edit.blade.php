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
                                        href="{{route('dashboard.core.service.index')}}">الخدمات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل خدمه</li>
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
                        <h3>إنشاء خدمه جديد</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.core.service.update', $service->id)}}" method="post"
                              class="form-horizontal"
                              enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                            @csrf
                            {!! method_field('PUT') !!}
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{__('dash.title_ar')}}</label>
                                        <input type="text" name="title_ar" class="form-control"
                                               id="inputEmail4" value="{{$service->title_ar}}"
                                               placeholder="{{__('dash.title_ar')}}"
                                        >
                                        @error('title_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{__('dash.title_en')}}</label>
                                        <input type="text" name="title_en" class="form-control"
                                               id="inputEmail4" value="{{$service->title_en}}"
                                               placeholder="{{__('dash.title_en')}}"
                                        >
                                        @error('title_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-3">

                                        <label for="inputEmail4">{{__('dash.category')}}</label>
                                        <select id="inputState" class="select2 form-control pt-1"
                                                name="category_id">
                                            <option disabled>{{__('dash.choose')}}</option>
                                            @foreach($categories as $key => $category)
                                                <option value="{{$key}}"
                                                        @if($key == $service->category_id) selected @endif>{{$category}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">المدة</label>
                                        <input type="text" name="duration" class="form-control"
                                               id="inputEmail4" value="{{$service->duration}}"
                                               placeholder="المدة"
                                        >
                                        @error('duration')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                {{--<div class="form-row mb-3">--}}





                                {{--<div class="col-md-6 custom-file-container form-group"--}}
                                {{--data-upload-id="mySecondImage">--}}
                                {{--<label>{{__('dash.upload')}}<a href="javascript:void(0)"--}}
                                {{--class="custom-file-container__image-clear"--}}
                                {{--title="Clear Image">x</a></label>--}}
                                {{--<div style="display: flex">--}}
                                {{--<label class="custom-file-container__custom-file">--}}
                                {{--<input type="file"--}}
                                {{--class="custom-file-container__custom-file__custom-file-input"--}}
                                {{--name="avatar"--}}
                                {{-->--}}
                                {{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
                                {{--<span--}}
                                {{--class="custom-file-container__custom-file__custom-file-control"></span>--}}
                                {{--</label>--}}

                                {{--<div class=" col-md-2 custom-file-container__image-preview"></div>--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--</div>--}}
                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_ar')}}</label>
                                        <textarea name="description_ar" class="ckeditor" cols="10"
                                                  rows="5">{{$service->description_ar}}</textarea>
                                        @error('description_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_en')}}</label>
                                        <textarea name="description_en" class="ckeditor" cols="10"
                                                  rows="5">{{$service->description_en}}</textarea>
                                        @error('description_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                </div>


                                <div class="form-row mb-2">


                                    <div
                                        class="form-group type-col @if($service->type == 'evaluative') col-md-4 @else col-md-6 @endif">

                                        <label for="inputEmail4">{{__('dash.type')}}</label>
                                        <select id="inputState" class="select2 type form-control"
                                                name="type">
                                            <option value="{{\App\Enums\Core\ServiceType::fixed()->value}}"
                                                    @if(\App\Enums\Core\ServiceType::fixed()->value == $service->type) selected @endif >{{\App\Enums\Core\ServiceType::fixed()->value}}</option>
                                            <option value="{{\App\Enums\Core\ServiceType::evaluative()->value}}"
                                                    @if(\App\Enums\Core\ServiceType::evaluative()->value == $service->type) selected @endif>{{\App\Enums\Core\ServiceType::evaluative()->value}}</option>

                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div
                                        class="form-group price-col @if($service->type == 'evaluative') col-md-4 @else col-md-6 @endif">


                                        <label for="inputEmail4">{{__('dash.price')}}</label>
                                        <input type="text" name="price" class="form-control"
                                               id="inputEmail4" value="{{$service->price}}"
                                               placeholder="{{__('dash.price')}}"
                                        >
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div
                                        class="form-group start_from @if($service->type == 'evaluative') col-md-4 @else col-md-6 @endif"
                                        @if($service->type == 'evaluative') style="display: block;"
                                        @else style="display: none;" @endif>

                                        <label for="inputEmail4">{{__('dash.start_from')}}</label>
                                        <input type="text" name="start_from" class="form-control"
                                               id="inputEmail4" value="{{$service->start_from}}"
                                               placeholder="{{__('dash.start_from')}}"
                                        >
                                        @error('start_from')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="form-row mb-2">


                                    <div class="form-group col-md-3">
                                        <label for="is_quantity"></label>
                                        <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                            <label class="mx-5" for="is_quantity">الكميه</label>
                                            <input type="checkbox" name="is_quantity" id="is_quantity" @if($service->is_quantity == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('is_quantity')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="is_quantity"></label>
                                        <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                            <label class="mx-5" for="is_quantity">الاكثر مبيعا</label>
                                            <input type="checkbox" name="best_seller" id="best_seller" @if($service->best_seller == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('best_seller')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                <div class="form-group col-md-6">

                                    <label for="measurement_id">وحدات القياس</label>
                                    <select id="measurement_id"  class="select2 form-control pt-1"
                                            name="measurement_id" required>
                                        <option disabled>{{__('dash.choose')}}</option>
                                        @foreach($measurements as $measurement)
                                            <option value="{{$measurement->id}}" @if($measurement->id == $service->measurement_id) selected @endif>{{$measurement->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('measurement_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                </div>


                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.term_cond_ar')}}</label>
                                        <textarea name="ter_cond_ar" class="ckeditor" cols="10"
                                                  rows="5">{{$service->ter_cond_ar}}</textarea>
                                        @error('ter_cond_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.term_cond_en')}}</label>
                                        <textarea name="ter_cond_en" class="ckeditor" cols="10"
                                                  rows="5">{{$service->ter_cond_en}}</textarea>
                                        @error('ter_cond_en')
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




@push('script')
    <script>

        $("body").on('change', '.type', function () {
            if ($(this).val() == 'evaluative') {

                $('.type-col').removeClass('col-md-6');
                $('.type-col').addClass('col-md-4');
                $('.price-col').removeClass('col-md-6');
                $('.price-col').addClass('col-md-4');
                $('.start_from').show();
                $('.start_from').removeClass('col-md-6');
                $('.start_from').addClass('col-md-4');


            } else {
                $('.type-col').removeClass('col-md-4');
                $('.type-col').addClass('col-md-6');
                $('.price-col').removeClass('col-md-4');
                $('.price-col').addClass('col-md-6');
                $('.start_from').hide();
                $('.start_from').val('');

            }

        })


    </script>
    <script>

        $('.select2').select2({
            tags: true,
            dir: '{{app()->getLocale() == "ar"? "rtl" : "ltr"}}'
        })
    </script>
@endpush
