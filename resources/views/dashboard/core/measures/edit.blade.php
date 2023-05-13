<div class="modal fade " id="editMeasureModel" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل وحدة القياس</h5>
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
                      enctype="multipart/form-data" id="edit_measure_form" data-parsley-validate="">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="box-body">

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="edit_name_ar">اسم الحالة باللغة العربية</label>
                                <input type="text" name="name_ar" class="form-control"
                                       id="edit_name_ar"
                                       placeholder="أدخل الإسم"
                                >
                                @error('name_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_name_en">اسم الحالة باللغة الإنجليزية</label>
                                <input type="text" name="name_en" class="form-control"
                                       id="edit_name_en"
                                       placeholder="أدخل الإسم"
                                >
                                @error('name_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="form-row mb-3">

                            <div class="form-group col-md-6">
                                <label for="edit_symbol_ar">اختصار الوحدة باللغة العربية</label>
                                <input type="text" name="symbol_ar" class="form-control"
                                       id="edit_symbol_ar"
                                       placeholder="أدخل اختصار"
                                >
                                @error('symbol_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edit_symbol_en">اختصار الوحدة باللغة الإنجليزية</label>
                                <input type="text" name="symbol_en" class="form-control"
                                       id="edit_symbol_en"
                                       placeholder="أدخل اختصار"
                                >
                                @error('symbol_en')
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

