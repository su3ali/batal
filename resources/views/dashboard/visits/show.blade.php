@extends('dashboard.layout.layout')
@push('style')
    <link href="{{asset('css/VisitShowStyle.css')}}" rel="stylesheet" type="text/css"/>
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
                                <li class="breadcrumb-item active" aria-current="page">عرض الطلب</li>
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

            <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-md-5">
                                    <h3 class="card-title">تفاصيل الطلب</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-bordered nowrap">

                                <thead>

                                <tr>
                                    <th>رقم الزياره</th>
                                    <td>{{$visits->visite_id}}</td>
                                </tr>
                                <tr>
                                    @if($visits->booking && $visits->booking->type == 'service')
                                    <th>اسم التصنيف</th>
                                    <td>{{$visits->booking?->category?->title}}</td>

                                    @else
                                        <th>اسم الباقه</th>
                                        <td>{{$visits->booking?->package?->name}}</td>
                                    @endif
                                </tr>
                                <tr>
                                        <th>اسماء الخدمات</th>

                                        <td>
                                            @foreach($services as $service)
                                                <button class="btn-sm btn-primary">{{$service}}</button>
                                            @endforeach
                                        </td>

                                </tr>
                                <tr>
                                    <th>اسم المجموعه الفنيه</th>
                                    <td>{{$visits->group?->name}}</td>
                                </tr>
                                <tr>
                                    <th>موعد الزياره</th>
                                    <td>{{$visits->booking?->date}}</td>
                                </tr>

                                <tr>
                                    <th>تاريخ البدء</th>
                                    <td>{{$visits->start_time}}</td>
                                </tr>

                                <tr>
                                    <th>تاريخ الانتهاء</th>
                                    <td>{{$visits->end_time}}</td>
                                </tr>

                                <tr>
                                    <th>الحاله</th>
                                    <td>{{$visits->status?->name}}</td>
                                </tr>
                            @if($visits->visits_status_id == 6)
                                <tr>
                                    <th>سبب الالغاء</th>
                                    <td>{{$visits->cancelReason?->reason}}</td>
                                </tr>
                            @endif

                                @if($visits->visits_status_id == 5)
                                    <tr>
                                        <th>صوره اكتمال الطلب</th>
                                        <td><img class="img-fluid" style="width: 40px;" src="{{asset($visits->image)}}"></td>
                                    </tr>
                                @endif

                                <tr>
                                    <th>الملاحظات</th>
                                    <td>{!! $visits->note !!}</td>
                                </tr>

                                </thead>

                            </table><!-- end of table -->


                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div id="floating-panel">
                                <b>Mode of Travel: </b>
                                <select id="mode">
                                    <option value="DRIVING">Driving</option>
                                    <option value="WALKING">Walking</option>
                                    <option value="BICYCLING">Bicycling</option>
                                    <option value="TRANSIT">Transit</option>
                                </select>
                            </div>
                            <div id="map">

                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </div>



            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-body p-0">

                            <div class="stepper-horizontal" id="stepper1">
                                @foreach($visit_status as $key => $status)
                                <div class="step" data-id="{{$status->id}}">
                                    <div class="step-circle">
{{--                                        <span>{{$status->id}}</span>--}}
                                    </div>
                                    <div class="step-title">{{$status->name}}</div>
                                    @if($key != $visit_status->keys()->last())
                                    <div class="step-bar-left"></div>
                                    @endif

                                </div>
                                @endforeach

                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </div>


        </div>

    </div>
@endsection

@php
    $latUser = $visits->booking?->address?->lat;
    $longUser = $visits->booking?->address?->long;
    $latTechn = $visits->lat??0;
    $longTechn = $visits->long??0;

    $locations = [
        ['lat'=>(int)$latUser,'lng'=>(int)$longUser],
        ['lat'=>(int)$latTechn,'lng'=>(int)$longTechn],
    ];
@endphp
@push('script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#html5-extension').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [[0, 'desc']],
                "language": {
                    "url": "{{app()->getLocale() == 'ar'? '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json' : '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json'}}"
                },
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.visits.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'visite_id', name: 'visite_id'},
                    {data: 'date', name: 'date'},
                    {data: 'group_name', name: 'group_name'},
                    {data: 'start_time', name: 'start_time'},
                    {data: 'end_time', name: 'end_time'},
                    {data: 'duration', name: 'duration'},
                    {data: 'status', name: 'status'},
                    {data: 'control', name: 'control', orderable: false, searchable: false},

                ]
            });
        });

    </script>

    <script type="text/javascript">

        $(document).ready(function () {
            visitStatus();
        })

            function visitStatus(){
            var id = "{{$visits->id}}";
            $.ajax({
                url: '{{route('dashboard.visits.updateStatus')}}',
                type: 'post',
                data: {id: id,_token: "{{csrf_token()}}"},
                success: function (data) {
                    var steps = document.getElementsByClassName('step');

                    $.each(steps,function(index, node){
                        var stepNum = node.getAttribute('data-id');
                        if(data != 5 && data != 6){
                            console.log(stepNum)

                            if (stepNum == data) {
                                node.setAttribute("id", "await");
                            }
                            if (stepNum < data) {
                                node.setAttribute("id", "done");
                            }
                        }else if(data == 5 || data == 6){


                            if(stepNum == 5 && data == 5){
                                node.querySelector('.step-bar-left').setAttribute("style", "display:none;")
                            }

                            if (stepNum == data) {
                                node.setAttribute("id", "done");

                            }
                            if (stepNum < data) {
                                node.setAttribute("id", "done");
                            }

                            if(stepNum == 6 && data == 5){
                                node.setAttribute("style", "display:none;");
                            }else if(stepNum == 5 && data == 6){
                                node.setAttribute("style", "display:none;");
                            }


                        }


                    })
                }
            });
        }

    </script>

    <script type="text/javascript">

        function getLocation(){
            var id = "{{$visits->id}}";
            $.ajax({
                url: '{{route('dashboard.visits.getLocation')}}',
                type: 'post',
                data: {id: id,_token: "{{csrf_token()}}"},
                success: function (data) {
                    updatePosition(data)
                }
            });
        }
        let map;
        let directionsRenderer;
        function initMap() {
            const locations = <?php echo json_encode($locations) ?>;
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
                // center: myLatLng,
            });



            updatePosition(locations);
            document.getElementById("mode").addEventListener("change", () => {
                updatePosition(locations);
            });

            directionsRenderer.setMap(map);


        }



        function updatePosition(locations)
        {

            directionsRenderer = new google.maps.DirectionsRenderer();
            var directionsService = new google.maps.DirectionsService();

            calculateAndDisplayRoute(directionsService, directionsRenderer,locations);
            document.getElementById("mode").addEventListener("change", () => {
                calculateAndDisplayRoute(directionsService, directionsRenderer,locations);
            });


        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer,locations) {
            const selectedMode = document.getElementById("mode").value;

            directionsService
                .route({
                    origin: { lat: locations[1].lat , lng: locations[1].lng },
                    destination: { lat: locations[0].lat , lng: locations[0].lng },

                    travelMode: google.maps.TravelMode[selectedMode],
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);
                })
                .catch((e) => swal({
                    title: "فشل طلب الاتجاهات",
                    text: "لا يمكن العثور على طريق بين الأصل والوجهة",
                    type: 'error',
                    padding: '2em'
                })
            );
        }

        window.initMap = initMap;



        setInterval(getLocation,10000)
        setInterval(visitStatus,10000)

    </script>

    <script type="text/javascript" async defer
            src="https://maps.google.com/maps/api/js?key={{ Config::get('app.GOOGLE_MAP_KEY') }}&callback=initMap" ></script>

@endpush
