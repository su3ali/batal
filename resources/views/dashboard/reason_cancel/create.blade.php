<div class="modal fade " id="createBookingStatusModel" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إنشاء حالة حجز</h5>
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
                <form action="{{route('dashboard.reason_cancel.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="create_order_status_form" data-parsley-validate="">
                    @csrf
                    <div class="box-body">

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="reason_ar">سبب الالغاء باللغة العربية</label>
                                <input type="text" name="reason_ar" class="form-control"
                                       id="reason_ar"
                                       placeholder="أدخل السبب"
                                >
                                @error('reason_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="reason_en">سبب الالغاء باللغة الإنجليزية</label>
                                <input type="text" name="reason_en" class="form-control"
                                       id="reason_en"
                                       placeholder="أدخل السبب"
                                >
                                @error('reason_en')
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

