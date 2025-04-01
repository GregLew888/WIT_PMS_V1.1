@extends('layouts.app', ['class' => 'login-page', 'page' => _('Login Page'), 'contentClass' => 'login-page'])

@section('content')
    <div class="col-md-10 text-center ml-auto mr-auto">
        <!-- <h3 class="mb-5">Log in to view your holdings.</h3> -->
    </div>
    <div class="col-lg-6 col-md-6 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('login') }}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header mt-5 ml-2">
                    <img src="{{ asset('white') }}/img/WIT-logo-2024.png" alt="">
                    {{-- <h1 class="card-title" >{{ __('Log in') }}</h1> --}}
                </div>
                <div class="card-body mt-5">
                    <!-- <p class="text-dark mb-2">Sign in with email and password</p> -->
                    <label class="form-label" style="font-weight: 600;">{{ _('EMAIL OR USERNAME') }}</label>
                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">

                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Username Or Email') }}" value="{{old('email')}}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <label class="form-label" style="font-weight: 600;">{{ _('PASSWORD') }}</label>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="{{ _('Password') }}" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="txtPassword">
                        <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon" style="margin-top: 12px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" href="" class="btn btn-success btn-lg btn-block mb-3">{{ _('Login') }}</button>
                    <div class="pull-left">
                        <!-- <h6>
                            <a href="" class="link footer-link">{{ _('Create Account') }}</a>
                        </h6> -->
                    </div>
                    <div class="pull-right">
                        <h6>
                            <a href="{{ route('password.request') }}" class="footer-link">{{ _('Forgot password?') }}</a>
                        </h6>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $("#toggle_pwd").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#txtPassword").attr("type", type);
        });
    });
</script>
@endsection
