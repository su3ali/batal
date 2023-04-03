<?php
$appName = 'site_name_' . app()->getLocale();
?>
    <!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$settings->$appName}}</title>
    {{--    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">--}}
    <link rel="stylesheet"
          href="{{app()->getLocale() == 'ar'? asset('css/bootstrap.rtl.css') : asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://vjs.zencdn.net/7.20.3/video-js.css">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&family=Lora:ital,wght@0,500;0,700;1,400;1,500&display=swap"
        rel="stylesheet">
    <link href="{{asset(app()->getLocale().'/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset(app()->getLocale().'/assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
</head>
<link rel="stylesheet" href="{{asset('css/style.css')}}">

<body style="{{app()->getLocale()=='ar'? 'direction: rtl' : 'direction: ltr'}}">
<!---Header----->
<div class="header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-lg-end">
                    <a href="{{route('dashboard.login')}}" class="login">
                        <i class="far fa-user"></i>{{__('dash.login')}}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg main-nav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#linksNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="#">
                <img src="{{asset('/images/logo-1.png')}}">
            </a>

            <div class="language d-lg-none d-block">
                <a href="{{app()->getLocale() == 'ar'? route('dashboard.lang', 'en') : route('dashboard.lang', 'ar')}}">
                    <img
                        src="{{app()->getLocale() == 'ar'? 'https://flagcdn.com/h20/us.png': 'https://flagcdn.com/h20/sa.png'}}">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="linksNav">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{__('dash.home')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">{{__("dash.about")}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{__('dash.feature')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#subscriptions">{{__('dash.packages')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">{{__('dash.contact_us')}}</a>
                    </li>
                </ul>
            </div>

            <div class="language d-lg-block d-none">
                <a href="{{app()->getLocale() == 'ar'? route('dashboard.lang', 'en') : route('dashboard.lang', 'ar')}}">
                    <img
                        src="{{app()->getLocale() == 'ar'? 'https://flagcdn.com/h20/us.png': 'https://flagcdn.com/h20/sa.png'}}">
                </a>
            </div>
        </div>
    </nav>
</div>
<!---------Home page---------->
<div id="home_page">
    <!-----about section-->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 image">
                    <img src="{{app()->getLocale() == 'en'? asset('images/about-1-en.png'): asset('images/about-1.png')}}">
                </div>
                <div class="col-lg-5 text">
                    {!! $abouts[0]['description'] !!}
                </div>
            </div>
        </div>
    </section>
    <!-----about2 section-->
    <section id="about2" class="d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text">
                    <div class="logo">
                        <img src="{{asset('images/logo-1.png')}}">
                        <h2>{{$settings->$appName}}</h2>
                    </div>
                    <div class="tree">
                        {{--                        <img src="{{asset('images/list.jpg')}}" class="tree-image">--}}
                        {!! $abouts[1]['description'] !!}
                    </div>
                </div>
                <div class="col-lg-4 video">
                    <video-js id="about2Video"
                              autoplay controls
                              class="video-js vjs-big-play-centered about2Video-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-has-started vjs-playing vjs-user-inactive"
                              muted="true" height="500" loop="true" data-setup="{}" tabindex="-1" role="region"
                              lang="ar" translate="no" aria-label="Video Player">
                        <source src="{{app()->getLocale() == 'en'? asset('images/DigitalFood-en.mp4'): asset('images/DigitalFood.mp4')}}" type="video/mp4">
                    </video-js>
                </div>
            </div>
        </div>
    </section>
    <!---------about3 section----------------->
    <section id="about3">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 image">
                    <img src="{{app()->getLocale() == 'en'? asset('images/about-3-en.png'): asset('images/about-3.png')}}">
                </div>
                <div class="col-lg-6 text">
                    {!! $abouts[2]['description'] !!}
                </div>
            </div>
        </div>
    </section>
    <!---------features section----------------->
    <section id="features">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 main-title">
                    <h2>{{__('dash.feature')}}</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="first-carsoul owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
                        @if($features->first())
                            @foreach($features as $feature)
                                <div class="item">
                                    <div class="feature-item">
                                        <div class="card">
                                            <img src="{{$feature->getImageAttribute()}}">
                                            <div class="card-body" style="height: 180px !important; overflow: hidden">
                                                {!! $feature->description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------bakates section----------------->
    <section id="subscriptions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 main-title">
                    <h2>{{__('dash.packages')}}</h2>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row gap-lg-0 gap-4">
                @if($packages->first())
                    @foreach($packages as $package)
                        <div class="col-lg-4">
                            <div class="package">
                                <div class="details">
                                    <h5 class="title">({{$package->title}})</h5>
                                    <div class="price">
                                        @if($package->price)
                                            <div class="amount">{{$package->price}} $</div>
                                            <div class="period fw-bolder">{{__('dash.monthly')}}</div>
                                        @else
                                            <div class="amount">&nbsp;</div>
                                            <div class="period fw-bolder">{{__('dash.Contact_us_to_set_a_price')}}</div>
                                        @endif
                                    </div>
                                    <a href="#" class="register">
                                        <button class="btn brn-danger">
                                            {{__('dash.subscribe_now')}}
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    {!! $package->description !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!------------partener section----------------->
    <section id="partners">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 main-title">
                    <h2>{{__('dash.success_partners')}}</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="second-carousel owl-carousel owl-theme">
                        @foreach($success_partners as $success_partner)
                            <div class="item" style="width: 179.2px; margin-left: 75px;">
                                <img src="{{$success_partner->getImageAttribute()}}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--------------contact section----------------->
    <section id="contact">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 main-title">
                    <h2>{{__('dash.contact_us')}}</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 form-container">
                    <form class="row" action="{{route('frontend.contactUs')}}" method="POST">
                        @csrf
                        <div class="col-lg-6 mb-3">
                            <label class="col-form-label">{{__('dash.first_name')}}</label>
                            <input class="form-control" name="first_name" required="">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="col-form-label">{{__('dash.last_name')}}</label>
                            <input class="form-control" name="last_name" required="">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-form-label">{{__('dash.email')}}</label>
                            <input class="form-control" name="email" type="email" required="">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-form-label">{{__('dash.message')}}</label>
                            <textarea class="form-control" style="height: 80px !important;" name="message" rows="5" required=""></textarea>
                        </div>
                        <div class="col-lg-8 d-grid mx-auto">
                            <button type="submit" class="btn btn-danger">{{__('dash.send')}}</button>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-12">
                            <ul class="links">
                                <li>
                                    <a href="#">
                                        <i class="fas fa-envelope-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-snapchat-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--------------map section----------------->
    <section class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14838.306627623553!2d39.1082886!3d21.6024419!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf11d981517c55a1f!2z2LDYpyDZh9mK2K8g2YPZiNin2LHYqtix2LIg2KjYstmG2LMg2KjYp9ix2YM!5e0!3m2!1sar!2ssa!4v1635332690710!5m2!1sar!2ssa"></iframe>
    </section>
    <!--------------footer section----------------->
    <section class="footer">
        <div>
            <div class="maroof">
                <a href="#" target="_blank">
                    <img src="{{asset('images/maroof.png')}}">
                </a>
            </div>
            <div class="line1">© {{__('dash.all_rights_reserved')}} 2023</div>
            <div>® {{$settings->$appName}}</div>
        </div>
    </section>
</div>
<a href="https://api.whatsapp.com/send?phone=+966125780110" class="whatsapp" target="_blank">
    <img src="{{asset('images/whatsapp.png')}}">
</a>


<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=6356874fee9bd38475549fc7"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/promise-polyfill.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{asset(app()->getLocale().'/plugins/sweetalerts/custom-sweetalert.js')}}"></script>
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
</script>
</body>
</html>
