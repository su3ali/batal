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
                                        href="{{ route('dashboard.region.index') }}">{{ __('dash.region') }}</a>
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
                    <div class="form-group col-md-12">

                        <div id="map">

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection


@push('script')
    <script>
        var map;
        var polygon;
        var polygonCoordinates = {!! json_encode($region->polygon_coordinates) !!};
        polygonCoordinates = JSON.parse(polygonCoordinates)

        function initMap() {
            if (polygonCoordinates) {
                var center = polygonCoordinates[1]
            } else {
                var center = {
                    lat: 24.6310665,
                    lng: 46.5635056
                };
            }

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: center,
            });

            if (polygonCoordinates) {
                polygon = new google.maps.Polygon({
                    paths: polygonCoordinates,
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map
                });
            }

        }

 
    </script>

    <script type="text/javascript" async defer
        src="https://maps.google.com/maps/api/js?key={{ Config::get('app.GOOGLE_MAP_KEY') }}&callback=initMap&libraries=drawing">
    </script>
@endpush
