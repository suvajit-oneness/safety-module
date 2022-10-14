@extends('layouts.app')

@section('template_linked_css')
    {{-- Bootstrap
    ======================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">





    {{-- Custom Css
    ======================= --}}
    <style>
        .navbar{
            background-color: #ffffff !important;
            margin-bottom:20px !important;
            background: #ffffff;
            box-shadow:  5px 5px 10px #a7a7a7,
                        -5px -5px 10px #ffffff;
        }
        body{
            background-color: #e1e1e1;
        }



        /* numorphispm  */
        .numo-btn{
            /* position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); */


        border-radius: 10px!important;
        background: #ffff !important;
        
        }

        .numo-btn-close{
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-fb{
            width: 10rem;
            color: blue;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-twt{
            width: 10rem;
            color: #55acee;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-goog{
            width: 10rem;
            color: #dd4b39;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-git{
            width: 10rem;
            color: #444;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-yt{
            width: 10rem;
            color: red;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-twi{
            width: 10rem;
            color: #643fa6;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-insta{
            width: 10rem;
            color: #3f729b;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }

        .numo-btn-signa{
            width: 10rem;
            color: #5ac45e;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid blue;
        }


        /* hover */

        .numo-btn-close:hover{

            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-fb:hover{
            color: blue;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-twt:hover{
            color: #55acee;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-goog:hover{
            color: #dd4b39;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-git:hover{
            color: #444;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-yt:hover{
            color: red;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-twi:hover{
            color: #643fa6;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-insta:hover{
            color: #3f729b;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            
        }

        .numo-btn-signa:hover{
            color: #5ac45e;
            border-radius: 10px;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
           
        }



        .form-control{
            border-radius: 10px !important;
            background: #ffffff !important;
            border: 1px solid black;
        }
        /* numorphispm end */
        .card-header{
            border-radius: 10px 10px 0px 0px !important;
        }





        .header__center {

            font-size: 23px;
            display: grid;
            grid-template-columns: 1fr max-content 1fr;
            grid-column-gap: 1.0rem;
            align-items: center;
        }
        .round{
            border-radius: 50px;
            background: #e0e0e0;
            
        }

        .header__center::before,
        .header__center::after {
            color:#6c757d ;
            content: "";
            display: block;
            height: 2px;
            background-color: #6c757d ;
        }
        .form-group label{
            font-weight: 700;
        }
    </style>







@endsection


@section('content')
<div class="container-fluid">

            <div class="numo-btn ml-auto mr-auto" style="width: 86vw;" >
                <div class="card-header bg-info text-light text-center"><h3>{{ __('Register') }}</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        @if(config('settings.reCaptchStatus'))
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-4 my-5">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-primary w-75 text-light" style="color: black;">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>


                        {{-- ========== Social =============== --}}
                        <div class="row">
                            <div class="col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                                <h6 class="header__center mb-5 w-100">
                                    <div class="round text-secondary p-3">
                                        OR
                                        {{-- Or Use Social Logins to Register --}}
                                    </div>
                                </h6>
                                @include('partials.socials')
                            </div>
                        </div>

                    </form>
                </div>
            </div>

</div>
@endsection

@section('footer_scripts')
    @if(config('settings.reCaptchStatus'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@endsection
