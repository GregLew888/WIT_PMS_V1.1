@php
Auth::logout();
@endphp
@extends('layouts.app', ['class' => 'login-page', 'page' => _('Reset password'), 'contentClass' => 'login-page'])

@section('content')
    <div class="col-lg-5 col-md-7 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('password.email') }}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header mt-5 ml-2">
                    <img src="{{ asset('white') }}/img/WIT-logo-2024.png" alt="">
                    <!-- <img src="{{ asset('white') }}/img/card-primary.png" alt=""> -->
                    <!-- <h1 class="card-title">{{ _('Reset password') }}</h1> -->
                    <br>
                </div>
                <div class="card-body mt-5">
                    @include('alerts.success')

                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg btn-block mb-3">{{ _('Send Password Reset Link') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
