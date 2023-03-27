<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('admin.Edit Category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form action="" method="post" class="form-horizontal"
                          enctype="multipart/form-data" id="demo-form1" data-parsley-validate="">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="box-body">
                            <input type="hidden" name="id" id="id" >
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="txtUser">
                                    {{__('admin.Title')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" value="" id="title" required="" class="form-control">
                                    @if ($errors->has('title'))
                                        <span class="text-danger ">
                                    <strong>{{ $errors->first('title') }}</strong>
                               </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('admin.Save changes')}}</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
