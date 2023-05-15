
    <div id="toggleAccordion">
        @for ($i = 0; $i < $package->visit_number; $i++)

        <div class="card">
            <div class="card-header" id="bookingHeader">
                <section class="mb-0 mt-0">
                    <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion{{$i}}" aria-expanded="true" aria-controls="defaultAccordion{{$i}}">
                         الحجز {{$i+1}}
                    </div>
                </section>
            </div>

            <div id="defaultAccordion{{$i}}" class="collapse @if($i == 0) show @endif" aria-labelledby="..." data-parent="#toggleAccordion">
                <div class="card-body">
                    <div class="col-md-12 mb-3">
                        <div class="row ">
                            <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">
                                <section class="calender-custom">
                                    <h5 class="fw-bold mb-5 ff-din-demi text-center">
                                        اختر تاريخ حجزك
                                    </h5>

                                    <input type="text" class="reservatoinData" data-itr="{{$i}}" required id="getData" name="day[{{$i}}]" hidden>
                                </section>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">
                                <section>
                                    <h5 class="fw-bold mb-5 ff-din-demi text-center">
                                        اختر الوقت المناسب
                                    </h5>

                                    <div class="d-flex gap-5 select-time-list flex-wrap" id="select-time-available_{{$i}}">
                                        <div class="text-center">
                                            <img width="40%" src="{{asset('images/time.png')}}">
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        @endfor

    </div>


{{--    <div class="widget-content widget-content-area br-6">--}}
{{--        <div class="col-md-12 text-left mb-3">--}}
{{--            <h3>الحجوزات</h3>--}}
{{--        </div>--}}

{{--        <div class="col-md-12 mb-3">--}}
{{--            <div class="row ">--}}
{{--                <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">--}}
{{--                    <section class="calender-custom">--}}
{{--                        <h5 class="fw-bold mb-5 ff-din-demi text-center">--}}
{{--                           اختر تاريخ حجزك--}}
{{--                        </h5>--}}

{{--                        <input type="text" class="reservatoinData" data-itr="{{$i}}" id="getData" name="day[{{$i}}]" hidden>--}}
{{--                    </section>--}}
{{--                </div>--}}
{{--                <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">--}}
{{--                    <section>--}}
{{--                        <h5 class="fw-bold mb-5 ff-din-demi text-center">--}}
{{--                            اختر الوقت المناسب--}}
{{--                        </h5>--}}

{{--                        <div class="d-flex gap-5 select-time-list flex-wrap" id="select-time-available_{{$i}}">--}}

{{--                        </div>--}}
{{--                    </section>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
