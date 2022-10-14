@extends('layouts.app')
@section('template_title')
    Login
@endsection


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
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;


            border-radius: 10px !important;
            background: #ffffff !important;

        }
        .numo-btn-close{
            border-radius: 10px !important;
            background: #e0e0e0 !important;
            box-shadow:  -5px 5px 5px #868686,
                        5px -5px 5px #ffffff !important;
        }


        /* hover */

        .numo-btn-close:hover{
            border-radius: 10px !important;
            background: linear-gradient(225deg, #cacaca, #f0f0f0) !important;
            box-shadow:  -6px 6px 11px #8f8f8f,
                        6px -6px 11px #ffffff !important;
        }

        .form-control{
            border-radius: 10px !important;
            background: #ffffff !important;
            /* box-shadow:  -5px 5px 5px #868686,
                        5px -5px 5px #ffffff !important; */
            border: 1px solid black;
        }
        /* numorphispm end */
        .card-header{
            border-radius: 10px 10px 0px 0px !important;
        }
        .form-group label{
            font-weight: 600;
        }
        .card-header{
            color: #ffffff;
            font-weight: 700;
        }
        .alert{
            z-index: 1;
            position: relative;
            /* top:485px; */
            background-color:white;
            /* bottom:-445; */
        }

        .numo-btn{
            margin-top: 41px;
        }
    </style>







@endsection

@section('content')
<div class="container-fluid">

            <div class="numo-btn" style="width: 30rem;">
                <div>
                    <div class="text-dark px-5 py-3 mx-auto  d-flex  text-center">
                       <img src='{{ asset('images/TCCflagwithoutbackground.png') }}' height="100px" width='100px'  >
                       <h2 class='' style='padding-left:3rem; margin-top:3rem;'>{{ __('Login') }}</h2>
                   </div>
                </div>
                <div class="card-body py-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
                        {{-- for display the password  --}}
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label class="d-flex">
                                        <i style="margin-top: 0.3em;" class="fa fa-eye-slash" aria-hidden="true" id="togglePassword"></i> <span style="margin-left: 10px;"> Show Password </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label class="d-flex">
                                        <!-- <input style="height: 14px; width:14px;" class="form-control mr-2 mt-1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }} -->
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4 my-5">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-danger w-50 text-light" style="color: black">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <!-- <a class="btn btn-link text-danger" href="{{ route('password.request') }}">
                                    {{ __('auth.forgot') }}
                                </a> -->
                            </div>
                        </div>

                        <!--<p class="text-center mb-3">
                            Or Login with
                        </p>

                         @include('partials.socials-icons') -->

                    </form>
                </div>
            </div>

</div>
<script>
    $(document).ready(function(){
        $('#togglePassword').on('click', function (e) {
            // toggle the type attribute
            var data_type = $('#password').attr('type');

            // toggle the eye / eye slash icon
            if(data_type == 'password'){
                $('#password').attr('type','text');
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
            }
            else{
                $('#password').attr('type','password');
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
            }

        });
    });

</script>
@endsection
