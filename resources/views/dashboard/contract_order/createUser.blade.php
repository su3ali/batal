<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="createUserModel" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة عميل</h5>
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
                <form id="userForm" method="post"
                       action="{{route('dashboard.order.customerStore')}}"
                       enctype="multipart/form-data">
                    @csrf

                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">{{__('dash.first name')}}</label>
                            <input type="text" name="first_name" class="form-control"
                                   id="inputEmail4"
                                   placeholder="{{__('dash.first name')}}">
                            @error('first_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">{{__('dash.last name')}}</label>
                            <input type="text" name="last_name" class="form-control"
                                   id="inputEmail4"
                                   placeholder="{{__('dash.last name')}}">
                            @error('last_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">{{__('dash.phone')}}</label>
                            <input type="text" name="phone" class="form-control"
                                   id="inputEmail4"
                                   placeholder="{{__('dash.phone')}}">
                            @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">{{__('dash.email')}}</label>
                            <input type="email" name="email" class="form-control"
                                   id="inputEmail4"
                                   placeholder="{{__('dash.email')}}"
                                   value="{{isset($model)?$model->email : ''}}">
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

                    <div class="form-group col-md-6">

                        <label for="inputEmail4">{{__('dash.city')}}</label>
                        <select id="inputState" class="select2 form-control pt-1"
                                name="city_id">
                            <option disabled>{{__('dash.choose')}}</option>
                            @foreach($cities as $key => $city)
                                <option value="{{$key}}">{{$city}}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

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
        $(document).ready(function () {
            $(document).on('submit', '#userForm', function (e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var actionUrl = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(response)
                    {

                        if (response.success === true) {
                            swal({
                                title: "{{__('dash.successful_operation')}}",
                                text: "{{__('dash.request_executed_successfully')}}",
                                type: 'success',
                                padding: '2em'
                            })
                        }
                        $('#createUserModel').modal('hide');

                        var newOption = new Option(response.data['first_name']+' '+response.data['last_name'], response.data['id'], true, true);
                        $('#customer_name').append(newOption).trigger('change');

                    },error: function(data){
                        var errors = data.responseJSON.errors;
                        var errorsHtml = '';
                        $.each( errors, function( key, value ) {
                            errorsHtml +=  value[0] + " " + "</br>"
                        });
                        swal({
                            title: "فشل العمليه",
                            text: errorsHtml,
                            type: 'error',
                            padding: '2em'
                        })
                    }
                });

            });
        });

    </script>
@endpush
