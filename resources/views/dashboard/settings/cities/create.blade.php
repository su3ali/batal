<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('dash.Create City')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.city.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                    @csrf
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.title_ar')}}</label>
                                <input type="text" name="title_ar" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.title_ar')}}"
                                       >
                                @error('title_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputEmail4">{{__('dash.title_en')}}</label>
                                <input type="text" name="title_en" class="form-control"
                                       id="inputEmail4"
                                       placeholder="{{__('dash.title_en')}}"
                                >
                                @error('title_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>


                        <div class="form-group col-md-6">

                            <label for="inputEmail4">{{__('dash.country')}}</label>
                            <select id="inputState" class="select2 form-control pt-1"
                                    name="country_id">
                                <option disabled>{{__('dash.choose')}}</option>
                                @foreach($countries as $key => $country)
                                    <option value="{{$key}}">{{$country}}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

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


