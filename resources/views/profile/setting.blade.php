@extends('layouts.app', ['page' => __('Site Setting'), 'pageSlug' => 'settings'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Site Settings Page') }}</h5>
                </div>
                <div class="profile-pic">
                    <label class="-label" for="company">
                        <span class="tim-icons icon-camera-18"></span>
                        <span>Change Image</span>
                    </label>
                    <input id="company" type="file" onchange="loadFile(event)"/>
                    <img src="{{asset($siteSetting->company_image_url) ?? ''}}" id="output" width="200" />
                </div>
                <form method="post" action="{{ route('settings.update') }}" autocomplete="off">
                    <div class="card-body">
                        @include('alerts.success')
                            @csrf
                            @method('put')


                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label>{{ _('Name') }}</label>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Name') }}" value="{{ old('name', $setting->name) }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group{{ $errors->has('short_name') ? ' has-danger' : '' }}">
                                <label>{{ _('Short Name') }}</label>
                                <input type="text" name="short_name" class="form-control{{ $errors->has('short_name') ? ' is-invalid' : '' }}" placeholder="{{ _('Short Name') }}" value="{{ old('short_name', $setting->short_name) }}">
                                @include('alerts.feedback', ['field' => 'short_name'])
                            </div>
                            

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label>{{ _('Email') }}</label>
                                <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email address') }}" value="{{ old('email', $setting->email) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>

                            <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                <label>{{ _('Phone Number') }}</label>
                                <input id="tel_phone" type="tel" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('tel_phone', $setting->phone_number) }}">
                                <input type="hidden" id="phone_number" name="phone_number" />
                                <span id="valid-msg" class="hide"></span>
                                <span id="error-msg" class="hide"></span>
                                @include('alerts.feedback', ['field' => 'phone_number'])
                            </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Password') }}</h5>
                </div>
                <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'password_status'])

                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                            <label>{{ __('Current Password') }}</label>
                            <input type="password" id="old_password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                            <span id="toggle_pwdo" class="fa fa-fw fa-eye field_icon" style="margin-top: -25px;margin-right: -10px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                       
                            @include('alerts.feedback', ['field' => 'old_password'])
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label>{{ __('New Password') }}</label>
                            <input type="password" id="textPassword" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required autocomplete="new-password">
                            <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon" style="margin-top: -25px;margin-right: -10px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                       
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm New Password') }}</label>
                            <input type="password" id="textPasswordc" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required autocomplete="new-password">
                            <span id="toggle_pwdc" class="fa fa-fw fa-eye field_icon" style="margin-top: -25px;margin-right: -10px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                       
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Change password') }}</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <a href="#">
                                <h5 class="title">{{ $setting->name }}</h5>
                            </a>
                            <p class="description">
                                {{ $setting->email }}
                            </p>
                        </div>
                    </p>
                    <div class="card-description">
                        <b>Phone Number</b>{{ $setting->phone_number }}<br><br><br>
                        <!-- <h3>
                            Total Earning: <b>56</b>
                        </h3>
                        <h3>
                            Profit: <b>65</b>
                        </h3> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#company').on('change', function() {
            let formData = new FormData();
            if ($('#company')[0].files.length > 0) {
                formData.append('company_image', $('#company')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: '{{route("company.image")}}',
                headers: {
                    'Accept': 'application/json',
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    
                    location.reload();
                },
            });
        });
        </script>
    @endpush
@endsection
