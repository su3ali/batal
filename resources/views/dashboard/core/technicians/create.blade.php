<div class="modal fade " id="technicianModal"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.create_technician')}}</h5>
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
                <form action="{{route('dashboard.core.technician.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                    @csrf
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">{{__('dash.name')}}</label>
                                <input required type="text" name="name" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.name')}}"
                                >
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">اسم الفني</label>
                                <input required type="text" name="user_name" class="form-control"
                                       id="inputEmail4"
                                       placeholder="اسم الفني المستخدم"
                                >
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">{{__('dash.email')}}</label>
                                <input type="email" name="email" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.email')}}"
                                >
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.password')}}</label>
                                <input type="password" name="password" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.password')}}"
                                >
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    for="inputEmail4">{{__('dash.password_confirmation')}}</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.password_confirmation')}}"
                                >
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.phone')}}</label>
                                <input required type="text" name="phone" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.phone')}}"
                                >
                            </div>

                            <div class="form-group col-md-6">

                                <label for="spec">التخصص</label>
                                <select id="spec" class="select2 form-control pt-1"
                                        name="spec_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($specs as $spec)
                                        <option value="{{$spec->id}}">{{$spec->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="inputEmail4">{{__('dash.nationality')}}</label>
                                <select required id="" class="select2 form-control pt-1"
                                        name="country_id">
                                    <option disabled>{{__('dash.choose')}}</option>
                                    {{--                                    @foreach($categories as $category)--}}
                                    <option value="1">Egypt</option>
                                    {{--                                    @endforeach--}}
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.identity_number')}}</label>
                                <input required type="text" name="identity_id" class="form-control"
                                       id=""
                                       placeholder="{{__('dash.identity_number')}}"
                                >
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="birth">{{__('dash.birth_date')}}</label>
                                <input required id="birth" name="birth_date" type="date" class="form-control datepicker"
                                       data-date-format="dd/mm/yyyy">

                            </div>

                            <div class="form-group col-md-6">

                                <label for="wallet">{{__('dash.wallet')}}</label>
                                <select required id="wallet" class="select2 form-control pt-1"
                                        name="wallet_id">
                                    <option disabled>{{__('dash.choose')}}</option>
                                    {{--                                    @foreach($categories as $category)--}}
                                    <option value="1">wallet</option>
                                    {{--                                    @endforeach--}}
                                </select>

                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col-md-6 custom-file-container form-group"
                                 data-upload-id="mySecondImage">
                                <label>{{__('dash.upload')}}<a href="javascript:void(0)"
                                                               class="custom-file-container__image-clear"
                                                               title="Clear Image">x</a></label>
                                <div style="display: flex">
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
                            <div class="form-group col-md-6">
                                <label for="address">{{__('dash.address')}}</label>
                                <textarea required type="text" name="address" class="form-control"
                                          id="address"
                                          rows="3"
                                          placeholder="{{__('dash.identity_number')}}"
                                ></textarea>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="group">{{__('dash.group')}}</label>
                                <select id="group" class="select2 form-control pt-1"
                                        name="group_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="status"></label>
                                <label class="switch s-outline s-outline-info  mb-4 mx-4 mt-3 d-block w-50">
                                    <label class="mx-5" for="status">{{__('dash.status')}}</label>
                                    <input type="checkbox" name="active" id="status" checked>
                                    <span class="slider round"></span>
                                </label>

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
        let secondUpload = new FileUploadWithPreview('mySecondImage')

    </script>
@endpush
