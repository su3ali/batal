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
                                <li class="breadcrumb-item active" aria-current="page">إنشاء خدمه</li>
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
                        <form action="{{route('dashboard.core.service.store')}}" method="post" class="form-horizontal"
                              enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                            @csrf
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{__('dash.title_ar')}}</label>
                                        <input type="text" name="title_ar" class="form-control"
                                               id="inputEmail4"
                                               placeholder="{{__('dash.title_ar')}}"
                                        >
                                        @error('title_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{__('dash.title_en')}}</label>
                                        <input type="text" name="title_en" class="form-control"
                                               id="inputEmail4"
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
                                                <option value="{{$key}}">{{$category}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">المدة</label>
                                        <input type="text" name="duration" class="form-control"
                                               id="inputEmail4"
                                               placeholder="المدة"
                                        >
                                        @error('duration')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_ar')}}</label>
                                        <textarea name="description_ar" class="ckeditor" cols="10" rows="5"></textarea>
                                        @error('description_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_en')}}</label>
                                        <textarea name="description_en" class="ckeditor" cols="10" rows="5"></textarea>
                                        @error('description_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                </div>


                                <div class="form-row mb-2">


                                    <div class="form-group type-col col-md-6">

                                        <label for="inputEmail4">{{__('dash.type')}}</label>
                                        <select id="inputState" class="select2 type form-control"
                                                name="type">
                                            <option
                                                value="{{\App\Enums\Core\ServiceType::fixed()->value}}">{{\App\Enums\Core\ServiceType::fixed()->value}}</option>
                                            <option
                                                value="{{\App\Enums\Core\ServiceType::evaluative()->value}}">{{\App\Enums\Core\ServiceType::evaluative()->value}}</option>

                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group price-col col-md-6">


                                        <label for="inputEmail4">{{__('dash.price')}}</label>
                                        <input type="text" name="price" class="form-control"
                                               id="inputEmail4"
                                               placeholder="{{__('dash.price')}}"
                                        >
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group start_from col-md-4" style="display: none;">

                                        <label for="inputEmail4">{{__('dash.start_from')}}</label>
                                        <input type="text" name="start_from" class="form-control"
                                               id="inputEmail4"
                                               placeholder="{{__('dash.start_from')}}"
                                        >
                                        @error('start_from')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="form-row mb-2">
{{--                                    <div class="form-group col-md-6">--}}

{{--                                        <label for="group_ids">المجموعات</label>--}}
{{--                                        <select id="group_ids" multiple class="select2 form-control pt-1"--}}
{{--                                                name="group_ids[]" required>--}}
{{--                                            <option disabled>{{__('dash.choose')}}</option>--}}
{{--                                            @foreach($groups as $group)--}}
{{--                                                <option value="{{$group->id}}">{{$group->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('group_ids')--}}
{{--                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}

{{--                                    </div>--}}

                                    <div class="form-group col-md-6">
                                        <label for="is_quantity"></label>
                                        <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                            <label class="mx-5" for="is_quantity">الكميه</label>
                                            <input type="checkbox" name="is_quantity" id="is_quantity" checked>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-row mb-2">


                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.term_cond_ar')}}</label>
                                        <textarea name="ter_cond_ar" class="ckeditor" cols="10" rows="5"></textarea>
                                        @error('ter_cond_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.term_cond_en')}}</label>
                                        <textarea name="ter_cond_en" class="ckeditor" cols="10" rows="5"></textarea>
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




{{--<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-xl" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.Create Service')}}</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <form action="{{route('dashboard.core.service.store')}}" method="post" class="form-horizontal"--}}
{{--                      enctype="multipart/form-data" id="demo-form" data-parsley-validate="">--}}
{{--                    @csrf--}}
{{--                    <div class="box-body">--}}
{{--                        <div class="form-row mb-3">--}}
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="inputEmail4">{{__('dash.title_ar')}}</label>--}}
{{--                                <input type="text" name="title_ar" class="form-control"--}}
{{--                                       id="inputEmail4"--}}
{{--                                       placeholder="{{__('dash.title_ar')}}"--}}
{{--                                       >--}}
{{--                                @error('title_ar')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="inputEmail4">{{__('dash.title_en')}}</label>--}}
{{--                                <input type="text" name="title_en" class="form-control"--}}
{{--                                       id="inputEmail4"--}}
{{--                                       placeholder="{{__('dash.title_en')}}"--}}
{{--                                >--}}
{{--                                @error('title_en')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}


{{--                            <div class="form-group col-md-4">--}}

{{--                                <label for="inputEmail4">{{__('dash.category')}}</label>--}}
{{--                                <select id="inputState" class="select2 form-control pt-1"--}}
{{--                                        name="category_id">--}}
{{--                                    <option disabled>{{__('dash.choose')}}</option>--}}
{{--                                    @foreach($categories as $key => $category)--}}
{{--                                        <option value="{{$key}}">{{$category}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('category_id')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}

{{--                            </div>--}}

{{--                        </div>--}}


{{--                        --}}{{--<div class="form-row mb-3">--}}


{{--                            --}}{{--<div class="col-md-6 custom-file-container form-group"--}}
{{--                                 --}}{{--data-upload-id="mySecondImage">--}}
{{--                                --}}{{--<label>{{__('dash.upload')}}<a href="javascript:void(0)"--}}
{{--                                                               --}}{{--class="custom-file-container__image-clear"--}}
{{--                                                               --}}{{--title="Clear Image">x</a></label>--}}
{{--                                --}}{{--<div style="display: flex">--}}
{{--                                    --}}{{--<label class="custom-file-container__custom-file">--}}
{{--                                        --}}{{--<input type="file"--}}
{{--                                               --}}{{--class="custom-file-container__custom-file__custom-file-input"--}}
{{--                                               --}}{{--name="avatar"--}}
{{--                                        --}}{{-->--}}
{{--                                        --}}{{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
{{--                                        --}}{{--<span--}}
{{--                                            --}}{{--class="custom-file-container__custom-file__custom-file-control"></span>--}}
{{--                                    --}}{{--</label>--}}

{{--                                    --}}{{--<div class=" col-md-2 custom-file-container__image-preview"></div>--}}
{{--                                --}}{{--</div>--}}
{{--                            --}}{{--</div>--}}

{{--                        --}}{{--</div>--}}
{{--                        <div class="form-row mb-2">--}}


{{--                                <div class="form-group col-md-6">--}}

{{--                                    <label for="inputEmail4">{{__('dash.description_ar')}}</label>--}}
{{--                                    <textarea name="description_ar" class="ckeditor" cols="10" rows="5"></textarea>--}}
{{--                                    @error('description_ar')--}}
{{--                                    <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}

{{--                                </div>--}}

{{--                            <div class="form-group col-md-6">--}}

{{--                                <label for="inputEmail4">{{__('dash.description_en')}}</label>--}}
{{--                                <textarea name="description_en" class="ckeditor" cols="10" rows="5"></textarea>--}}
{{--                                @error('description_en')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}

{{--                            </div>--}}


{{--                        </div>--}}


{{--                        <div class="form-row mb-2">--}}


{{--                            <div class="form-group type-col col-md-6">--}}

{{--                                <label for="inputEmail4">{{__('dash.type')}}</label>--}}
{{--                                <select id="inputState" class="select2 type form-control"--}}
{{--                                        name="type">--}}
{{--                                    <option value="{{\App\Enums\Core\ServiceType::fixed()->value}}">{{\App\Enums\Core\ServiceType::fixed()->value}}</option>--}}
{{--                                    <option value="{{\App\Enums\Core\ServiceType::evaluative()->value}}">{{\App\Enums\Core\ServiceType::evaluative()->value}}</option>--}}

{{--                                </select>--}}
{{--                                @error('category_id')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}

{{--                            </div>--}}

{{--                                <div class="form-group price-col col-md-6">--}}


{{--                                    <label for="inputEmail4">{{__('dash.price')}}</label>--}}
{{--                                    <input type="text" name="price" class="form-control"--}}
{{--                                           id="inputEmail4"--}}
{{--                                           placeholder="{{__('dash.price')}}"--}}
{{--                                    >--}}
{{--                                    @error('price')--}}
{{--                                    <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}

{{--                                </div>--}}

{{--                                <div class="form-group start_from col-md-4" style="display: none;">--}}

{{--                                    <label for="inputEmail4">{{__('dash.start_from')}}</label>--}}
{{--                                    <input type="text" name="start_from" class="form-control"--}}
{{--                                           id="inputEmail4"--}}
{{--                                           placeholder="{{__('dash.start_from')}}"--}}
{{--                                    >--}}
{{--                                    @error('start_from')--}}
{{--                                    <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}


{{--                        </div>--}}

{{--                        <div class="form-row mb-2">--}}


{{--                            <div class="form-group col-md-6">--}}

{{--                                <label for="inputEmail4">{{__('dash.term_cond_ar')}}</label>--}}
{{--                                <textarea name="ter_cond_ar" class="ckeditor" cols="10" rows="5"></textarea>--}}
{{--                                @error('ter_cond_ar')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}

{{--                            </div>--}}

{{--                            <div class="form-group col-md-6">--}}

{{--                                <label for="inputEmail4">{{__('dash.term_cond_en')}}</label>--}}
{{--                                <textarea name="ter_cond_en" class="ckeditor" cols="10" rows="5"></textarea>--}}
{{--                                @error('ter_cond_en')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}

{{--                            </div>--}}


{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>--}}
{{--                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{__('dash.close')}}</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


@push('script')
    <script>

        $("body").on('change', '.type', function () {
            if ($(this).val() == 'evaluative') {

                $('.type-col').removeClass('col-md-6');
                $('.type-col').addClass('col-md-4');
                $('.price-col').removeClass('col-md-6');
                $('.price-col').addClass('col-md-4');
                $('.start_from').show();


            } else {
                $('.type-col').removeClass('col-md-4');
                $('.type-col').addClass('col-md-6');
                $('.price-col').removeClass('col-md-4');
                $('.price-col').addClass('col-md-6');
                $('.start_from').hide();

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
