@php
    $name = 'site_name_'.app()->getLocale();
    $msgs = [];
    if (session('errors')){
        foreach(session('errors')->getmessages() as $message){
            foreach ($message as $m){
              $msgs[] = $m;
            }
        }
    }
@endphp
    <!DOCTYPE html>
{{--<html lang="{{app()->getLocale()}}">--}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{\App\Models\Setting::first()?\App\Models\Setting::first()->$name : 'site name'}}</title>
    @if(\App\Models\Setting::first()->logo != null)
    <link rel="icon" type="image/x-icon" href="{{asset(\App\Models\Setting::first()->logo)}}"/>
    @else
        <link rel="icon" type="image/x-icon" href="{{asset(app()->getLocale().'/assets/img/favicon.ico')}}"/>
    @endif
    {{--<link href="{{asset(app()->getLocale().'/assets/css/loader.css')}}" rel="stylesheet" type="text/css"/>--}}
    {{--<script src="{{asset(app()->getLocale().'/assets/js/loader.js')}}"></script>--}}
    <link href="{{asset(app()->getLocale().'/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">

    <link href="{{asset(app()->getLocale().'/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
{{--    <link href="{{asset(app()->getLocale().'/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{asset(app()->getLocale().'/assets/css/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/font-icons/fontawesome/css/regular.css')}}">
    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/font-icons/fontawesome/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset(app()->getLocale().'/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset(app()->getLocale().'/plugins/table/datatable/custom_dt_html5.css')}}">

    <link rel="stylesheet" type="text/css"
          href="{{asset(app()->getLocale().'/plugins/table/datatable/dt-global_style.css')}}">
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    <link href="{{asset('/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/select2/select2.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <link href="{{asset(app()->getLocale().'/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet"
          type="text/css"/>


    <link href="{{asset(app()->getLocale().'/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset(app()->getLocale().'/assets/css/components/custom-sweetalert.css')}}" rel="stylesheet"
          type="text/css"/>
    <link
        href="{{asset(app()->getLocale().'/assets/css/components/custom-modal.css" rel="stylesheet" type="text/css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{asset(app()->getLocale().'/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset(app()->getLocale().'/plugins/jquery-ui/jquery-ui.theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        body {
            font-family: Cairo, Serif !important;
        }

        .ck-editor__editable {
            height: 200px;
        }
        .custom-file-container__image-preview{
            height: auto!important;
        }

        span.select2.select2-container.select2-container--bootstrap4 {
            width: auto!important;
        }

        .ui-autocomplete{
            right: 342.676px!important;
            width: 349.021px;
        }

        .flatpickr-current-month .numInputWrapper{
            display: none;
        }

        label.radio span {
            padding: 3px 23px;
            border: 2px solid #eee;
            display: inline-block;
            background-color: #f1f2f3;
            color: #039be5;
            border-radius: 10px;
            width: 100%;
            height: 38px;
            line-height: 29px;
            margin-bottom: 0px;
            margin-left: 0;
        }

        .select-time {
            margin-left: 5px;
        }

        label.radio input {
            position: absolute;
            top: 0;
            left: 0;
            visibility: hidden;
            pointer-events: none;
        }

        label.radio input:checked+span {
            border-color: #039BE5;
            background-color: #0a58ca;
            color: #fff;
            border-radius: 9px;
            margin-bottom: 0;
        }

        label.radio input:disabled+span {
            border-color: #acb3bd;
            background-color: #acb3bd;
            color: #fff;
            border-radius: 9px;

            margin-bottom: 0;
        }


       .logo img{
            width: 48px;
            border-radius: 4px;
            height: 43px;
        }

    </style>
    @stack('style')
    <script type="text/javascript" src="{{ asset('admin_dashboard/bower_components/ckeditor/ckeditor.js') }}"></script>
</head>


<body data-spy="scroll" data-target="#navSection" data-offset="100">

<!--  BEGIN NAVBAR  -->
@include('dashboard.layout.navbar')
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
@yield('sub-header')
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    @include('dashboard.layout.sidebar')
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        {{--<div class="container">--}}
        {{--<div class="container">--}}



        @yield('content')

        {{--</div>--}}
        {{--</div>--}}
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2021 <a target="_blank" href="https://designreset.com">DesignReset</a>, All
                    rights reserved.</p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">Coded with
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-heart">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </p>
            </div>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset(app()->getLocale().'/plugins/apex/apexcharts.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/assets/js/dashboard/dash_2.js')}}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{asset(app()->getLocale().'/assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/font-icons/feather/feather.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/promise-polyfill.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/custom-sweetalert.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/toastr/toastr.min.js')}}"></script>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="{{asset('js/flatpickr.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    feather.replace();
    Dropzone.autoDiscover=false;
</script>
<script>
    $(document).ready(function () {

        let session = "{{session('success')}}"
        if (session) {
            swal({
                title: "{{__('dash.successful_operation')}}",
                text: "{{__('dash.request_executed_successfully')}}",
                type: 'success',
                padding: '2em'
            })
        }
        let arr = [];
        <?php foreach ($msgs as $key => $val){ ?>
        arr.push('<?php echo $val; ?>');
        <?php } ?>
        if (arr[0]) {
            let text = '';
            for (let i = 0; i < arr.length; i++) {
                text +=  arr[i]
            }
            swal({
                title: "{{__('dash.error')}}",
                html: text,
                type: 'error',
                padding: '2em'
            })
        }
    })
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        let url = $(this).data('href')
        let that = $(this);
        swal.fire({
            title: "{{__('dash.Are_you_sure?')}}",
            text: "{{__("dash.You_won't_be_able_to_restore_it_again")}}",
            showCancelButton: true,
            confirmButtonText: "{{__('dash.Yes,delete')}}",
            cancelButtonText: "{{__('dash.No,cancel')}}"
        }).then((isConfirm) => {
            if (isConfirm.value) {
                $.post(url, {_method: 'DELETE', _token: '{{csrf_token()}}'}).done(function (response) {
                    if (response.success === true) {
                        swal(
                            "{{__('dash.Deleted!')}}",
                            "{{__('dash.Your_file_has_been_deleted.')}}",
                            'success'
                        )
                        $('.table').DataTable().ajax.reload();
                    } else {
                        swal(
                            "فشل الحذف",
                            ""+response.msg+"",
                            'error'
                        )
                    }
                })
            }
        });
    });


    $(document).ready(function() {
        "use strict";
        $(".timepicker").timepicker({
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

    });

</script>

{{--<script>--}}
{{--var table =  $('.html5-extension').DataTable( {--}}
{{--"dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +--}}
{{--"<'table-responsive'tr>" +--}}
{{--"<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",--}}
{{--buttons: {--}}
{{--buttons: [--}}
{{--{ extend: 'copy', className: 'btn btn-sm' },--}}
{{--{ extend: 'csv', className: 'btn btn-sm' },--}}
{{--{ extend: 'excel', className: 'btn btn-sm' },--}}
{{--{ extend: 'print', className: 'btn btn-sm' }--}}
{{--]--}}
{{--},--}}
{{--"oLanguage": {--}}
{{--"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },--}}
{{--"sInfo": "Showing page _PAGE_ of _PAGES_",--}}
{{--"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',--}}
{{--"sSearchPlaceholder": "Search...",--}}
{{--"sLengthMenu": "Results :  _MENU_",--}}
{{--},--}}
{{--"stripeClasses": [],--}}
{{--"lengthMenu": [7, 10, 20, 50],--}}
{{--"pageLength": 7--}}
{{--} );--}}
{{--</script>--}}
<script>
    $(document).ready( function(){
        $("select:not(.swal2-select)").select2({
            width: 'element',
            theme: 'bootstrap4',
        });
    });

</script>
{{--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>--}}

@stack('script')

</body>


</html>
