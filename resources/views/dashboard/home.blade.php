@extends('.dashboard.layout.layout')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                {{__('dash.welcome_message')}}: {{auth('dashboard')->user()->name}}
            </div>
        </div>

@endsection
