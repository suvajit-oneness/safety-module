<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('template_title')@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
        <meta name="description" content="">
        <meta name="author" content="Jeremy Kenedy">
        <link rel="shortcut icon" href="/favicon.ico">
        <script src="{{ asset('js/momentjs/moment.js') }}"></script>


        {{-- Jquery
        ================================== --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        {{-- numorphiso apply --}}
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">



            {{-- Toastr
            ========================================== --}}
            {{-- <link href="/js/custom/toastr/toastr.min.css" rel="stylesheet"> --}}
            
            {{-- Edited by Onenesstechs --}}
            <link href="{{asset('/js/custom/toastr/toastr.min.css')}}" rel="stylesheet">

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"/> -->

        {{--  fontawsome
        =========================  --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        {{-- Fonts --}}
        @yield('template_linked_fonts')

        {{-- Styles --}}
        {{-- <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <link href="/css/global.css" rel="stylesheet"> --}}
        
        {{-- edited by Onenesstechs  --}}
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/global.css') }}" rel="stylesheet">

        {{-- Added by Onenesstechs --}}
        <script src="{{ asset('/js/app.js') }}"></script>
        <script defer type="text/javascript" src="{{asset('\js\custom\toastr\toastr.min.js')}}"></script>
        <script defer type="text/javascript" src="{{asset('\js\custom\toastr\notificationMessage.js')}}"></script>

        <script defer type="text/javascript" src="{{asset('\js\custom\block.js')}}"></script>


        <style type="text/css">
            @yield('template_fastload_css')

            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
                    background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
                    background-size: auto 100%;
                }
            @endif

        </style>
        @yield('partials_css')
        @yield('template_linked_css')
        <link rel="stylesheet" href="\js\custom\toastr\toastr.min.css"/>
        {{-- Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

        @if (Auth::User() && (Auth::User()->profile) && $theme->link != null && $theme->link != 'null')
            <link rel="stylesheet" type="text/css" href="{{ $theme->link }}">
        @endif

        @yield('head')
        @include('scripts.ga-analytics')
    </head>
    <body data-status="{{Session::get('status')}}">
        <div id="app">

            @include('partials.nav')

            <main class="">

                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            @include('partials.form-status')
                        </div>
                    </div>
                </div>

                @yield('content')

            </main>

        </div>

        {{--<!-- <div class="loader">
                            <img class="img img-responsive ajaxLoader hidden" hidden src="/images/ajax-loader.gif" style="display:block; position: fixed; z-index: 1031; top: 20%; right: 40%; margin-top: -..px; margin-right: -..px;">
                        </div> -->--}}

        {{-- Scripts --}}
        /* Commented By Onenesstechs */
        /* <script src="{{ mix('/js/app.js') }}"></script>
        <script defer type="text/javascript" src="\js\custom\toastr\toastr.min.js"></script>
        <script defer type="text/javascript" src="\js\custom\toastr\notificationMessage.js"></script>

        <script defer type="text/javascript" src="\js\custom\block.js"></script> */
        {{--<!-- <script type="text/javascript">
                            $(document).ajaxStart(function()
                            {
                              $(".ajaxLoader").removeAttr("hidden");
                            //$("#app").fadeTo("slow",0.1);
                            }).ajaxStop(function() {

                                $(".ajaxLoader").attr("hidden");
                                //$("#app").fadeTo("slow",1);
                            });
                        </script> -->--}}
        {{--<!-- @if(config('settings.googleMapsAPIStatus'))
                            {!! HTML::script('//maps.googleapis.com/maps/api/js?key='.config("settings.googleMapsAPIKey").'&libraries=places&dummy=.js', array('type' => 'text/javascript')) !!}
                        @endif -->--}}
        @yield('partial_scripts')
        @yield('footer_scripts')

    </body>
</html>
