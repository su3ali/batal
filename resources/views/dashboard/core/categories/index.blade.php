@extends('dashboard.layout.layout')

@section('sub-header')
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('dash.categories')}}</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>

            <div class="flex-row ml-auto">

                <button type="button" class="btn btn-primary card-tools" data-toggle="modal" data-target="#exampleModal">
                    {{__('dash.add_new')}}
                </button>


            </div>



        </header>
    </div>

    @include('dashboard.core.categories.create')
@endsection


@section('content')


    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <table id="zero-config" class="table dt-table-hover " style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('dash.category name')}}</th>
                            <th>{{__('dash.status')}}</th>
                            <th class="no-content">{{__('dash.actions')}}</th>
                        </tr>
                        </thead>
                    </table>


                </div>
            </div>

        </div>

    </div>

@endsection


@push('script')

    <script type="text/javascript">
$('#zero-config').DataTable();
        $("body").on('change','#customSwitch4', function() {
            var active=$(this).is(':checked');
            var id=$(this).attr('data-id');

            $.ajax({
                url:'{{route('dashboard.core.administration.admins.change_status')}}',
                type:'get',
                data:{id:id,active:active},
                success:function (data){
                    swal({
                        title: "{{__('dash.successful_operation')}}",
                        text: "{{__('dash.request_executed_successfully')}}",
                        type: 'success',
                        padding: '2em'
                    })
                }
            });
        })

    </script>


@endpush
