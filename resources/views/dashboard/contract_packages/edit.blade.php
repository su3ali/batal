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
                                        href="{{route('dashboard.contract_packages.index')}}">باقات التقاول</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تعديل باقة التقاول</li>
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
                <div class="widget-content widget-content-area br-6" style="min-height: 500px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>تعديل باقة التقاول</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{route('dashboard.contract_packages.update', $ContractPackage->id)}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="edit-contract-package" data-parsley-validate="">
                            {!! method_field('PUT') !!}
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-4">

                                        <label for="birth">اسم الباقة بالعربي</label>
                                        <input required name="name_ar" value="{{$ContractPackage->name_ar}}" placeholder="اسم الباقة بالعربي" type="text" class="form-control">
                                        @error('name_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="birth">اسم الباقة بالانجليزي</label>
                                        <input required name="name_en" value="{{$ContractPackage->name_en}}" type="text" placeholder="اسم الباقة بالانجليزي" class="form-control">
                                        @error('name_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="service">الخدمة</label>
                                        <select required class="select2 form-control pt-1"
                                                name="service_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($services as $key => $service)
                                                <option value="{{$key}}" @if($ContractPackage->service_id == $key) selected @endif>{{$service}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>


                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-2">

                                        <label for="price">{{__('dash.price_value')}}</label>
                                        <input required type="number" value="{{$ContractPackage->price}}" step="0.1" name="price" class="form-control"
                                               id="price"
                                               placeholder="{{__('dash.price')}}"
                                        >
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-2">

                                        <label for="visit_number">عدد الزيارات </label>
                                        <input required type="number" step="0.1" value="{{$ContractPackage->visit_number}}" name="visit_number" class="form-control"
                                               id="visit_number"
                                               placeholder="عدد الزيارات "
                                        >
                                        @error('visit_number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="birth">الفترة</label>
                                        <input required name="time" type="text" value="{{$ContractPackage->time}}" placeholder="الفترة" class="form-control">
                                        @error('time')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>



                                    <div class="col-md-4 custom-file-container form-group"
                                         data-upload-id="myFirstImage">
                                        <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                                       class="custom-file-container__image-clear"
                                                                       title="Clear Image">x</a></label>
                                        <div style="display: flex">
                                            <label class="custom-file-container__custom-file">
                                                <input type="file"
                                                       class="custom-file-container__custom-file__custom-file-input"
                                                       name="avatar"
                                                >
                                                {{--<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>--}}
                                                <span
                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>

                                            <div class=" col-md-2 custom-file-container__image-preview"></div>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-row mb-3">


                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_ar')}}</label>
                                        <textarea name="description_ar" class="ckeditor" cols="30" rows="10">{{$ContractPackage->description_ar}}</textarea>
                                        @error('description_ar')->
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="inputEmail4">{{__('dash.description_en')}}</label>
                                        <textarea name="description_en" class="ckeditor" cols="30" rows="10">{{$ContractPackage->description_en}}</textarea>
                                        @error('description_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>



                                </div>

                            </div>

                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                    </div>

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


        let firstUpload = new FileUploadWithPreview('myFirstImage')



            var img = '{{$ContractPackage->avater}}';

            if (img != ''){

                $('#edit-contract-package .custom-file-container__image-preview').css('background-image', 'url("'+img+'")');
            }


    </script>
@endpush
