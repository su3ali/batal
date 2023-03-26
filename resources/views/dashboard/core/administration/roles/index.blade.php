@extends('dashboard.layout.layout')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="seperator-header layout-top-spacing d-flex justify-content-between">
                            <nav class="breadcrumb-one" aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 py-2">
                                    <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('dash.roles')}}</li>
                                </ol>
                            </nav>
                            <a href="{{route('dashboard.core.administration.roles.create')}}" class="btn btn-primary">{{__('dash.add_new')}}</a>
                        </div>
                        {{$dataTable->table(['class'=>'table table-hover non-hover text-center'])}}
                        {{--                        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">--}}

                        {{--                        </table>--}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')

    {{$dataTable->scripts()}}
@endpush
