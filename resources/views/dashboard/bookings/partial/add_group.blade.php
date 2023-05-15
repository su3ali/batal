<div class="modal fade " id="addGroupModel" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة فريق</h5>
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
                <form action="{{route('dashboard.visits.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id="create_order_status_form" data-parsley-validate="">
                    @csrf
                    <div class="box-body">

                        <input type="hidden" name="booking_id" id="booking_id">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-6">

                                <label for="group_ids">المجموعات</label>
                                <select id="group_id"  class="select2 form-control pt-1"
                                        name="assign_to_id" required>
                                    <option disabled selected>{{__('dash.choose')}}</option>

                                </select>
                                @error('group_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="status">الحاله</label>
                                <select id="status"  class="select2 form-control pt-1"
                                        name="status" required>
                                    <option disabled selected>{{__('dash.choose')}}</option>
                                    <option value="{{\App\Enums\Core\StatusVisit::scheduled()}}">{{\App\Enums\Core\StatusVisit::scheduled()}}</option>
                                    <option value="{{\App\Enums\Core\StatusVisit::delayed()}}">{{\App\Enums\Core\StatusVisit::delayed()}}</option>
                                    <option value="{{\App\Enums\Core\StatusVisit::under_procedure()}}">{{\App\Enums\Core\StatusVisit::under_procedure()}}</option>
                                    <option value="{{\App\Enums\Core\StatusVisit::finished()}}">{{\App\Enums\Core\StatusVisit::finished()}}</option>
                                    <option value="{{\App\Enums\Core\StatusVisit::canceled()}}">{{\App\Enums\Core\StatusVisit::canceled()}}</option>

                                </select>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group reason_cancel col-md-6" style="display:none;">

                                <label for="inputEmail4">سبب الالغاء</label>
                                <textarea name="reason_cancel" class="ckeditor" cols="10" rows="5"></textarea>
                                @error('reason_cancel')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group notes col-md-12">

                                <label for="inputEmail4">ملاحظات</label>
                                <textarea name="note" class="ckeditor" cols="10" rows="5"></textarea>
                                @error('notes')
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

