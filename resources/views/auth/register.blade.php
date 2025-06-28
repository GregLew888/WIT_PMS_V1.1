@extends('layouts.app', ['class' => 'register-page', 'page' => _('Register Page'), 'contentClass' => 'register-page'])

@section('content')
    <div class="row">
        <div class="col-md-5 ml-auto">
            <!-- <div class="info-area info-horizontal mt-5">
                <div class="icon icon-warning">
                    <i class="tim-icons icon-wifi"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ _('Manage ') }}</h3>
                    <p class="description">
                        {{ _('') }}
                    </p>
                </div>
            </div> -->
            <div class="info-area info-horizontal">
                <div class="icon icon-primary">
                    <i class="tim-icons icon-triangle-right-17"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ _('Register Now') }}</h3>
                    <p class="description">
                        {{ _('Register now to fully utilized the powerful features of Shipping Management System') }}
                    </p>
                </div>
            </div>
            <!-- <div class="info-area info-horizontal">
                <div class="icon icon-info">
                    <i class="tim-icons icon-trophy"></i>
                </div>
                <div class="description">
                    <h3 class="info-title">{{ _('Built Audience') }}</h3>
                    <p class="description">
                        {{ _('There is also a Fully Customizable CMS Admin Dashboard for this product.') }}
                    </p>
                </div>
            </div> -->
        </div>
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-header">
                    <!-- <img class="card-img" src="{{ asset('white') }}/img/card-primary.png" alt="Card image"> -->
                    <h4 class="card-title" style="color: #243834;">{{ _('Register') }}</h4>
                </div>
                @include('alerts.success')
                <form class="form" method="post" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Name') }}" value="{{ old('name') }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-badge"></i>
                                </div>
                            </div>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}" value="{{ old('email') }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="input-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('phone_number') }}">
                            @include('alerts.feedback', ['field' => 'phone_number'])
                        </div>
                        <div class="input-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-notes"></i>
                                </div>
                            </div>
                            <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ _('Username') }}" value="{{ old('username') }}">
                            @include('alerts.feedback', ['field' => 'username'])
                        </div>
                        <div class="input-group{{ $errors->has('location') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-pin"></i>
                                </div>
                            </div>
                            <input type="text" name="location" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" placeholder="{{ _('Location') }}" value="{{ old('location') }}">
                            @include('alerts.feedback', ['field' => 'location'])
                        </div>
                        <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" id="textPassword" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ _('Password') }}">
                            <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon" style="margin-top: 12px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                       
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" id="textPasswordc" name="password_confirmation" class="form-control" placeholder="{{ _('Confirm Password') }}">
                            <span id="toggle_pwdc" class="fa fa-fw fa-eye field_icon" style="margin-top: 12px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                       
                        </div>
                            <div class=" mt-5 form-group{{ $errors->has('profile_image') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tim-icons icon-camera-18"></i>
                                        </div>
                                    </div>
                                <label for="formFileLg" class="form-label" style="font-size:large">Add Profile Photo</label>
                                <input class="form-control form-control-lg {{ $errors->has('profile_image') ? ' is-invalid' : '' }}" id="formFileLg" type="file" name="profile_image" accept="image/*">
                            @include('alerts.feedback', ['field' => 'profile_image'])
                            </div>     
                        <!-- <div class="form-check text-left {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label class="form-check-label">
                                <input class="form-check-input {{ $errors->has('agree_terms_and_conditions') ? ' is-invalid' : '' }}" name="agree_terms_and_conditions"  type="checkbox"  {{ old('agree_terms_and_conditions') ? 'checked' : '' }}>
                                <span class="form-check-sign"></span>
                                {{ _('I agree to the') }}
                                <a href="#">{{ _('terms and conditions') }}</a>.
                                @include('alerts.feedback', ['field' => 'agree_terms_and_conditions'])
                            </label>
                        </div> -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-round btn-lg">{{ _('Get Started') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript">
            $(function () {
                $("#toggle_pwd").click(function () {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
                    $("#textPassword").attr("type", type);
                });
                $("#toggle_pwdc").click(function () {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
                    $("#textPasswordc").attr("type", type);
                });
            });
        </script>
