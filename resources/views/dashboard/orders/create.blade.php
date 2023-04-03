<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="createOrderModel" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إنشاء طلب جديد</h5>
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
                <form action="{{route('dashboard.orders.store')}}" method="post" class="form-horizontal"
                      enctype="multipart/form-data" id='create_order_form' data-parsley-validate="">
                    @csrf
                    <div class="box-body">
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="customer_name">{{__('dash.customer_name')}}</label>
                                <select required id="customer_name" class="select2 form-control pt-1"
                                        name="user_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label for="category_id">{{__('dash.category')}}</label>
                                <select required id="category_id" class="select2 form-control pt-1"
                                        name="category_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">

                                <label for="service_id">{{__('dash.service')}}</label>
                                <select required id="service_id" class="select2 form-control pt-1"
                                        name="service_id">
                                    <option selected disabled>{{__('dash.choose')}}</option>
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}">{{$service->title}}</option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">
                                <label for="price">{{__('dash.price_value')}}</label>
                                <input required type="number" step="0.1" name="price" class="form-control"
                                       id="price"
                                       placeholder="{{__('dash.price')}}"
                                >
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group">
                                {!! Form::label('payment_method_visa', 'طريقة الدفع') !!}
                                <div class="">
                                    <label class="radio-inline">
                                        <input class="mx-2" value="visa" type="radio" name="payment_method" id="payment_method_visa" checked>دفع إلكتروني
                                    </label>
                                    <label class="radio-inline">
                                        <input class="mx-2" value="cache" type="radio" name="payment_method" id="payment_method_cache">دفع نقدي
                                    </label>
                                </div>
                                @error('payment_method')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-12">
                                <label for="notes">الملاحظات</label>
                                <textarea name="notes" id="notes" cols="30" rows="3" class="form-control"></textarea>
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

