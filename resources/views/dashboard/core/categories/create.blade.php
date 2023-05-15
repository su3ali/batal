<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.Create Category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.core.category.store')}}" method="post" class="form-horizontal"
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


                            <div class="col-md-4 custom-file-container form-group"
                                 data-upload-id="mySecondImage">
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

                            <input type="hidden" name="parent_id" value="">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">

                                <label for="group_ids">المجموعات</label>
                                <select id="group_ids" multiple class="select2 form-control pt-1"
                                        name="group_ids[]" required>
                                    <option disabled>{{__('dash.choose')}}</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                                @error('group_ids')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <div class="form-row mb-3">


                                <div class="form-group col-md-6">

                                    <label for="inputEmail4">{{__('dash.description_ar')}}</label>
                                    <textarea name="description_ar" class="ckeditor" cols="30" rows="10"></textarea>
                                    @error('description_ar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.description_en')}}</label>
                                <textarea name="description_en" class="ckeditor" cols="30" rows="10"></textarea>
                                @error('description_en')
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
        let secondUpload = new FileUploadWithPreview('mySecondImage')
    </script>
    @endpush
