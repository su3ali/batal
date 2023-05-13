@extends('dashboard.layout.layout')

@push('style')
    <style>
        #bookingHeader{
            background-color : rgb(239 245 255) !important;
        }
    </style>

@endpush
@section('sub-header')
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>

                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.contract_order.index')}}">طلب تقاول</a></li>
                                <li class="breadcrumb-item active" aria-current="page">إنشاء طلب</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>

@endsection

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6" style="min-height: 400px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>إنشاء طلب جديد</h3>
                    </div>
                    @include('dashboard.contract_order.createUser')

                    <div class="col-md-12">
                        <form action="{{route('dashboard.contract_order.store')}}" method="post" class="form-horizontal"
                              enctype="multipart/form-data" id='create_order_form' data-parsley-validate="">
                            @csrf
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">

                                        <label for="customer_name">{{__('dash.customer_name')}}</label>
                                        <select required id="customer_name" class="select2 form-control pt-1"
                                                name="user_id" data-live-search="true">
                                            {{--                                            <option selected disabled>{{__('dash.choose')}}</option>--}}
                                            {{--                                            @foreach($users as $user)--}}
                                            {{--                                                <option value="{{$user->id}}">{{$user->name}}</option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                        @error('user_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="col-md-2 mt-4">
                                        <button type="button" class="btn btn-primary card-tools" data-toggle="modal"
                                                data-target="#createUserModel">
                                            <i data-feather="plus-circle"></i>
                                        </button>


                                    </div>
                                </div>


                                @include('dashboard.contract_order.serviceTable')


                                <div class="col-xl-12 col-lg-12 col-sm-12 reservition  layout-spacing" style="display:none;">

                                </div>

                                <div class="widget-content widget-content-area m-3 mt-0">
                                    <div class="form-row  card bg-light-dark m-3">
                                        <div class="form-group col-md-12 mt-2">
                                            <h4 for="notes">الاجمالي الكلي
                                                :
                                                <span id="totalafterdiscountspan">0</span>
                                            </h4>

                                            <input hidden name="price" id="totalafterdiscount"
                                                   class="form-control">

                                        </div>
                                    </div>

                                    <div class="form-row m-3">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="notes">الملاحظات</label>
                                                <textarea name="notes" id="notes" cols="30" rows="3"
                                                          class="form-control"></textarea>
                                                @error('notes')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                {!! Form::label('payment_method_visa', 'طريقة الدفع') !!}
                                                <div class="mt-2">
                                                    <label class="radio-inline">
                                                        <input class="mx-2" value="visa" type="radio" name="payment_method"
                                                               id="payment_method_visa" checked>دفع إلكتروني
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="mx-2" value="cache" type="radio" name="payment_method"
                                                               id="payment_method_cache">دفع نقدي
                                                    </label>
                                                </div>
                                                @error('payment_method')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>


                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                                        <button class="btn btn-dark" data-dismiss="modal"><i
                                                class="flaticon-cancel-12"></i> {{__('dash.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

@push('script')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').ready(function () {
            $('#customer_name').select2({
                placeholder: "ابحث عن عميل",
                allowClear: true,
                minimumInputLength: 1,
                width: 'element',
                theme: 'bootstrap4',
                language: {
                    inputTooShort: function (args) {
                        return "ادخل حرف او اكثر";
                    }
                },
                ajax: {
                    url: "{{ route('dashboard.order.autoCompleteCustomer') }}",

                    data: function (params) {
                        var query = {
                            q: params.term,
                        }
                        return query;
                    },

                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                console.log(item);
                                return {
                                    text: item.first_name + ' ' + item.last_name,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: true,
                }


            });
        });
    </script>

    {{--date--}}
    <script>

        $('body').on('change', '#getData', function (e) {
            e.preventDefault()
            var Data = $(this).val();
            var itr = $(this).data('itr');

            $.ajax({
                url: "{{route('dashboard.contract_order.getAvailableTime')}}",
                data: {
                    'date': Data,
                    'id': $('.service_id-1').val(),
                    'itr': itr,
                },
                cache: false,
                success: function (html) {
                    $('#select-time-available_'+itr).html(html);
                }
            });

        });

        function any(val) {

        }
    </script>

    {{--table services--}}
    <script>
        $('body').on('click', '.plus-service', function () {
            var itr = $(this).attr('data-itr');
            itr++

            $('#item-service').append(`<tr><td style="width: 400px;">



                        <input type='text' class="form-control name-` + itr + `" data-itr="` + itr + `" >
                        <input type='hidden' class="service_id-` + itr + `" name="services[` + itr + `][service_id]"  >

                    </td>
                    <td style="width: 190px;">
                        <div class="input-group input-number">
                            <span class="input-group-btn"><button type="button" onclick="changeQty(this,` + itr + `)" class="btn btn-default btn-flat quantity-down"><i class="far fa-minus text-danger"></i></button></span>
                            <input type="number" value="1"  onkeyup="change(` + itr + `)" data-min="1" class=" quantity-` + itr + ` input_number input_quantity form-control"  name="services[` + itr + `][quantity]">
                            <span class="input-group-btn"><button type="button" onclick="changeQty(this,` + itr + `)" class="btn btn-default btn-flat quantity-up"><i class="far fa-pulse text-success"></i></button></span>
                        </div>

                    </td>

                    <td style="width: 200px;">
                        <input type="number" onkeyup="change(` + itr + `)"  class="form-control unit_price" id="unit_price-` + itr + `" name="services[` + itr + `][unit_price]">
                    </td>

                    <td>
                        <input type="hidden" id="total-` + itr + `" class="form-control pos_line_total" value="0">
                        <div id="rowTotal-` + itr + `">0</div> ريال
                    </td>

                    <td>
                        <button class="minus-service btn btn-danger" type="button">x</button>
                    </td>
                </tr>`);
            $(this).attr('data-itr', itr);
            $('#itr').val(itr);

            callMe();

        });

        $("body").on('click', '.minus-service', function () {
            var itr = $('.plus-service').attr('data-itr');
            itr--
            $('.plus-service').attr('data-itr', itr)
            $('#itr').val(itr);
            $(this).parent().parent().remove();
            pos_total_row()
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            callMe();
        });

        function callMe() {
            var hidden_itr = $('#itr').val();

            $('.name-' + hidden_itr).autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('dashboard.contract_order.autoCompleteContract') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            q: request.term,
                        },
                        success: function (data) {

                            response($.map(data, function (key, el) {
                                return {
                                    label: key.name_ar,
                                    value: key.id,
                                    price: key.price,
                                    visit_number : key.visit_number ?? 1

                                };
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    event.preventDefault();
                    // Set selection
                    $('.reservition').show();
                    $('.quantity-' + hidden_itr).attr("data-max", ui.item.visit_number);
                    $('.name-' + hidden_itr).val(ui.item.label); // display the selected text
                    $('.service_id-' + hidden_itr).val(ui.item.value); // save selected id to input
                    $('#unit_price-' + hidden_itr).val(ui.item.price);
                    $('.quantity-' + hidden_itr).val(ui.item.visit_number);
                    change($(this).attr('data-itr'))
                    showBookingDiv(ui.item.value)


                    return false;
                },
            })


        }


        function showBookingDiv(package_id) {

            $.ajax({
                url: "{{route('dashboard.contract_order.showBookingDiv')}}",
                data: {
                    'id': package_id
                },
                cache: false,
                success: function (html) {
                    $('.reservition').html(html);

                    $(".reservatoinData").flatpickr({
                        inline: true,
                        minDate: "today",
                        maxDate: new Date(new Date().getFullYear() + 1, 0, 0),
                        monthSelectorType: "static",
                        altInput: true,
                        altInputClass: "d-none",
                        clickOpens: true,
                        defaultDate: new Date(Date.now() + 2 * 24 * 60 * 60 * 1000),
                        locale: {
                            firstDayOfWeek: 6,
                            weekdays: {
                                shorthand: ["S", "M", "T", "W", "T", "F", "S"],
                            },
                        },
                    });
                }
            });

        }

        function changeQty(button, hidden_itr) {
            var input = $('.quantity-' + hidden_itr);

            var qty = parseFloat(input.val());

            var step = 1;
            if (input.data('step')) {
                step = input.data('step');
            }
            var min = parseFloat(input.data('min'));
            var max = parseFloat(input.data('max'));

            if ($(button).hasClass('quantity-up')) {
                //if max reached return false
                if (typeof max != 'undefined' && qty + step > max) {
                    return false;
                }
                var count = qty + step;

                input.val(count);
                input.change()
            } else if ($(button).hasClass('quantity-down')) {
                //if max reached return false
                if (typeof min != 'undefined' && qty - step < min) {
                    return false;
                }

                var count = qty - step;
                input.val(count);
                input.change()
            }

            change(hidden_itr)

        }

        function change(hidden_itr) {
            var price = parseFloat($('#unit_price-' + hidden_itr).val());
            var qty = parseFloat($('.quantity-' + hidden_itr).val());
            var total = price
            $('#total-' + hidden_itr).val(total)
            $('#rowTotal-' + hidden_itr).html(total)
            pos_total_row()

        }

        function pos_total_row() {

            var total_quantity = 0;
            var total_price = 0;

            $('table.pos_table tbody tr').each(function () {
                var qty = $(this).find('input.input_quantity');

                total_quantity = total_quantity + parseFloat(qty.val());


            });


            $('table.pos_table tbody tr').each(function () {
                var price = $(this).find('input.pos_line_total');
                total_price = total_price + parseFloat(price.val());
            });


            $('#totalafterdiscount').val(total_price);
            $('#totalafterdiscountspan').html(total_price);


            $('span.total_quantity').each(function () {
                $(this).html(total_quantity);
            });

            $('span.price_total').each(function () {
                $(this).html(total_price);
            });
        }

    </script>

@endpush
