<div class="modal fade " id="editTechModel"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.edit_technician')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="edit_tech_form" data-parsley-validate="">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-4">
                                <label for="edit_name">{{__('dash.name')}}</label>
                                <input type="hidden" id="tech_id" name="tech_id">
                                <input required type="text" name="name" class="form-control"
                                       id="edit_name"
                                       placeholder="{{__('dash.name')}}"
                                >
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="edit_user_name">اسم الفني</label>
                                <input required type="text"  name="user_name" class="form-control"
                                       id="edit_user_name"
                                       placeholder="اسم الفني المستخدم"
                                >
                                @error('user_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="edit_email">{{__('dash.email')}}</label>
                                <input type="email" name="email" class="form-control"
                                       id="edit_email"
                                       placeholder="{{__('dash.email')}}"
                                >
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
                                <label for="edit_phone">{{__('dash.phone')}}</label>
                                <input required type="text" name="phone" class="form-control"
                                       id="edit_phone"
                                       placeholder="{{__('dash.phone')}}"
                                >
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">

                                <label for="edit_spec">التخصص</label>
                                <select id="edit_spec" class="select2 form-control pt-1"
                                        name="spec_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($specs as $spec)
                                        <option value="{{$spec->id}}">{{$spec->name}}</option>
                                    @endforeach
                                </select>
                                @error('specialization')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="edit_country_id">{{__('dash.nationality')}}</label>
                                <select required id="edit_country_id" class="select2 form-control pt-1"
                                        name="country_id">
                                    <option disabled>{{__('dash.choose')}}</option>
                                    {{--                                    @foreach($categories as $category)--}}
                                    <option value="1">Egypt</option>
                                    {{--                                    @endforeach--}}
                                </select>
                                @error('country_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_identity_id">{{__('dash.identity_number')}}</label>
                                <input required type="text" name="identity_id" class="form-control"
                                       id="edit_identity_id"
                                       placeholder="{{__('dash.identity_number')}}"
                                >
                                @error('identity')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="edit_birth">{{__('dash.birth_date')}}</label>
                                <input required id="edit_birth" name="birth_date" type="date" class="form-control datepicker"
                                       data-date-format="dd/mm/yyyy">
                                @error('birth_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="edit_wallet">{{__('dash.wallet')}}</label>
                                <select required id="edit_wallet" class="select2 form-control pt-1"
                                        name="wallet_id">
                                    <option disabled>{{__('dash.choose')}}</option>
                                    {{--                                    @foreach($categories as $category)--}}
                                    <option value="1">wallet</option>
                                    {{--                                    @endforeach--}}
                                </select>
                                @error('nationality')
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
                                <div style="display: flex">
                                    <label class="custom-file-container__custom-file">
                                        <input type="file"
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
                            <div class="form-group col-md-6">
                                <label for="edit_address">{{__('dash.address')}}</label>
                                <textarea required type="text" name="address" class="form-control"
                                          id="edit_address"
                                          rows="3"
                                          placeholder="{{__('dash.identity_number')}}"
                                ></textarea>
                                @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="edit_group">{{__('dash.group')}}</label>
                                <select id="edit_group" class="select2 form-control pt-1"
                                        name="group_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group col-md-6">
                                <label for="status"></label>
                                <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                    <label class="mx-5" for="edit_status">{{__('dash.status')}}</label>
                                    <input type="checkbox" name="active" id="edit_status">
                                    <span class="slider round"></span>
                                </label>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{__('dash.close')}}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@push('script')
    <script>
        let myImage = new FileUploadWithPreview('myImage')

    </script>
@endpush
