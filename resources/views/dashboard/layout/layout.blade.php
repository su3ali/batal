@php
    $name = 'site_name_'.app()->getLocale();
@endphp
    <!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{\App\Models\Setting::first()?\App\Models\Setting::first()->$name : 'site name'}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset(app()->getLocale().'/assets/img/favicon.ico')}}"/>
    <link href="{{asset(app()->getLocale().'/assets/css/loader.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{asset(app()->getLocale().'/assets/js/loader.js')}}"></script>
    <link href="{{asset(app()->getLocale().'/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/font-icons/fontawesome/css/regular.css')}}">
    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/font-icons/fontawesome/css/fontawesome.css')}}">
    <link href="{{asset(app()->getLocale().'/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset(app()->getLocale().'/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(app()->getLocale().'/plugins/table/datatable/dt-global_style.css')}}">
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    <link href="{{asset('/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/select2/select2.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset(app()->getLocale().'/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet"
          type="text/css"/>


    <link href="{{asset(app()->getLocale().'/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset(app()->getLocale().'/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        body{
            font-family: Cairo, Serif !important;
        }
        .ck-editor__editable {
            height: 200px;
        }
    </style>
    @stack('style')
    <script type="text/javascript" src="{{ asset('admin_dashboard/bower_components/ckeditor/ckeditor.js') }}"></script>
</head>
<body>
<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->

@include('dashboard.layout.navbar')

<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    @include('dashboard.layout.sidebar')

    <!--  BEGIN CONTENT AREA  -->
    <div class="main-container w-100" id="container">
        @yield('content')
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2021 <a target="_blank" href="https://designreset.com">DesignReset</a>, All rights reserved.</p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->
</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset(app()->getLocale().'/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/assets/js/app.js')}}"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
</script>
<script src="{{asset(app()->getLocale().'/assets/js/custom.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{asset(app()->getLocale().'/assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/font-icons/feather/feather.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/promise-polyfill.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/custom-sweetalert.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
<script src="{{asset('/select2/select2.min.js')}}"></script>
<script src="{{asset('/select2/select2.js')}}"></script>


<script src="{{asset(app()->getLocale().'/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/table/datatable/datatables.js')}}"></script>
<script
    src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
<script
    src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
<script
    src="{{asset(app()->getLocale().'/plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset(app()->getLocale().'/assets/css/forms/switches.css')}}">
<script type="text/javascript">
    feather.replace();
</script>
<script>
    $(document).ready(function (){

        let session = "{{session('success')}}"
        if (session){
            swal({
                title: "{{__('dash.successful_operation')}}",
                text: "{{__('dash.request_executed_successfully')}}",
                type: 'success',
                padding: '2em'
            })
        }
    })
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        let url = window.location+'/'+id+'/delete'
        let that = $(this);
        swal.fire({
            title: "{{__('dash.Are_you_sure?')}}",
            text: "{{__("dash.You_won't_be_able_to_restore_it_again")}}",
            showCancelButton: true,
            confirmButtonText: "{{__('dash.Yes,delete')}}",
            cancelButtonText: "{{__('dash.No,cancel')}}"
        }).then((isConfirm) => {
            if (isConfirm.value) {
                $.post(url, {_method: 'GET'}).done(function (response) {
                    if (response.status) {
                        $('.table').DataTable().ajax.reload();
                        swal(
                           "{{__('dash.Deleted!')}}",
                           "{{__('dash.Your_file_has_been_deleted.')}}",
                            'success'
                        )
                    } else {
                        console.log('no')
                        console.log(response.status)
                        swalInit.fire("Failed!", 'Unexpected error occurred', "error");
                        console.log(response);
                    }
                })
            }
        });
    });

</script>

<script>
</script>
@stack('script')
</body>
</html>
