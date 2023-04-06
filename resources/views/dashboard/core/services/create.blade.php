<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.Create Service')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.core.service.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                    @csrf
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">{{__('dash.title_ar')}}</label>
                                <input type="text" name="title_ar" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.title_ar')}}"
                                       >
                                @error('title_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">{{__('dash.title_en')}}</label>
                                <input type="text" name="title_en" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.title_en')}}"
                                >
                                @error('title_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group col-md-4">

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
                                    <option value="{{\App\Enums\Core\ServiceType::fixed()->value}}">{{\App\Enums\Core\ServiceType::fixed()->value}}</option>
                                    <option value="{{\App\Enums\Core\ServiceType::evaluative()->value}}">{{\App\Enums\Core\ServiceType::evaluative()->value}}</option>

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
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{__('dash.close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@push('script')
    <script>

        $("body").on('change', '.type', function () {
            if ($(this).val() == 'evaluative'){

            $('.type-col').removeClass('col-md-6');
            $('.type-col').addClass('col-md-4');
            $('.price-col').removeClass('col-md-6');
            $('.price-col').addClass('col-md-4');
            $('.start_from').show();


        }else{
                $('.type-col').removeClass('col-md-4');
                $('.type-col').addClass('col-md-6');
                $('.price-col').removeClass('col-md-4');
                $('.price-col').addClass('col-md-6');
                $('.start_from').hide();

            }

        })

    </script>
    @endpush
