@extends('dashboard.layout.layout')
@push('style')
    <link href="{{ asset('css/VisitShowStyle.css') }}" rel="stylesheet" type="text/css" />
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
                                        href="{{ route('dashboard.home') }}">{{ __('dash.home') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.region.index') }}">{{ __('dash.Region') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('dash.create') }}</li>
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
                <div class="widget-content widget-content-area br-6">
                    <form action="{{ route('dashboard.region.store') }}" method="post" class="form-horizontal"
                        enctype="multipart/form-data" id="demo-form" data-parsley-validate="">
                        @csrf
                        <div class="box-body">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{ __('dash.title_ar') }}</label>
                                    <input type="text" name="title_ar" class="form-control" id="inputEmail4"
                                        placeholder="{{ __('dash.title_ar') }}">
                                    @error('title_ar')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">{{ __('dash.title_en') }}</label>
                                    <input type="text" name="title_en" class="form-control" id="inputEmail4"
                                        placeholder="{{ __('dash.title_en') }}">
                                    @error('title_en')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">

                                    <label for="inputEmail4">{{ __('dash.city') }}</label>
                                    <select id="inputState" class="select2 form-control pt-1" name="city_id">
                                        <option disabled>{{ __('dash.choose') }}</option>
                                        @foreach ($cities as $key => $city)
                                            <option value="{{ $key }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
{{--                                 <div class="form-group col-md-6">

                                    <label for="inputEmail4">مسافه التغطيه بالكيلومتر</label>
                                    <input type="text" name="space_km" class="form-control" id="inputEmail4"
                                        placeholder="مسافه التغطيه بالكيلومتر">
                                    @error('space_km')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div> --}}
                            </div>
{{--                             <div class="row">
                                <div class="form-group col-md-6">

                                    <label for="inputEmail4">lat</label>
                                    <input type="text" name="lat" class="lat form-control" id="inputEmail4"
                                        placeholder="lat">
                                    @error('lat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="form-group col-md-6">

                                    <label for="inputEmail4">lon</label>
                                    <input type="text" name="lon" class="lon form-control" id="inputEmail4"
                                        placeholder="lon">
                                    @error('lon')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div> --}}


                            <div class="form-group col-md-12">

                                <div id="map">

                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('dash.save') }}</button>
                        </div>
                        <!-- Hidden field for polygon coordinates -->
                        <input type="hidden" name="polygon_coordinates" id="polygon_coordinates" />
                    </form>

                </div>
            </div>

        </div>

    </div>
@endsection


@push('script')
    <script>
        var map;
        var drawingManager;
        var selectedShape;

        function initMap() {
            var center = {
                lat: 24.6310665,
                lng: 46.5635056
            };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: center,
            });

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon']
                },
                polygonOptions: {
                    editable: true,
                    draggable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                if (selectedShape) {
                    selectedShape.setMap(null);
                }
                selectedShape = event.overlay;
                if (event.type == google.maps.drawing.OverlayType.POLYGON) {
                    var coordinates = event.overlay.getPath().getArray();
                    var coords = coordinates.map(function(latLng) {
                        return {
                            lat: latLng.lat(),
                            lng: latLng.lng()
                        };
                    });
                    $('#polygon_coordinates').val(JSON.stringify(coords));
                }
            });
        }
    </script>

    <script type="text/javascript" async defer
        src="https://maps.google.com/maps/api/js?key={{ Config::get('app.GOOGLE_MAP_KEY') }}&libraries=drawing&callback=initMap">
    </script>
@endpush
