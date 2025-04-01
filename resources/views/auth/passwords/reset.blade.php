@php
Auth::logout();
@endphp
@extends('layouts.app', ['class' => 'login-page', 'page' => _('Reset password'), 'contentClass' => 'login-page'])

@section('content')
    <div class="col-lg-6 col-md-7 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('password.update') }}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header mt-5 ml-2">
                    <img src="{{ asset('white') }}/img/WIT-logo-2024.png" alt="">
                    <!-- <img src="{{ asset('white') }}/img/card-primary.png" alt=""> -->
                    <!-- <h1 class="card-title">{{ _('Reset password') }}</h1> -->
                </div>
                <div class="card-body mt-5">
                    @include('alerts.success')

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="{{ $errors->has('email') ? ' has-danger' : '' }} mb-2">
                        {{-- <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div> --}}
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}" autocomplete="off" value="{{$email ?? ''}}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="{{ $errors->has('password') ? ' has-danger' : '' }} mb-2">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div> --}}
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ _('Password') }}" id="reset_password" autocomplete="new-password">
                            <span id="reset_password_e" class="fa fa-fw fa-eye field_icon" style="margin-top: -25px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 25px;"></span>
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="">
                            {{-- <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div> --}}
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ _('Confirm Password') }}" id="reset_password_confirm">
                            <span id="reset_password_confirm_e" class="fa fa-fw fa-eye field_icon" style="margin-top: -25px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 25px;"></span>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg btn-block mb-3">{{ _('Reset Password') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
