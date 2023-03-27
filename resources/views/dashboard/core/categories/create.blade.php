<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="txtUser">
                                {{__('admin.Title')}}</label>
                            <div class="col-sm-8">
                                <input type="text" name="title" id="txtUser" required="" class="form-control">
                                @if ($errors->has('title'))
                                    <span class="text-danger ">
                <strong>{{ $errors->first('title') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="txtUser">
                                {{__('admin.status')}}</label>
                            <div class="col-sm-3">
                                <input type="checkbox" name="status" value="1" checked class="form-control">
                                @if ($errors->has('status'))
                                    <span class="text-danger ">
                <strong>{{ $errors->first('status') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">{{__('admin.Save')}}</button>
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{__('admin.Close')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
