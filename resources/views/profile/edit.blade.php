@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (!$changePassword && !$errors->has('old_password') && !$errors->has('password'))
                
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{auth()->user()->name}}</h5>
                </div>
          
<<<<<<< HEAD
                <div class="profile-pic">
                    <label class="-label" for="profile">
                        <span class="tim-icons icon-camera-18"></span>
                        <span>Change Image</span>
                    </label>
                    <input id="profile" type="file" onchange="loadFile(event);"/>
                    <img src="{{auth()->user()->getFirstMediaUrl('profile_image')}}" id="output" width="200" />
                </div>
=======
>>>>>>> d00f9ff (Updated PMS backup from external hard drive)
                <form method="post" action="{{ route('profile.update') }}" autocomplete="off" id="profile_update_form">
                    <div class="card-body">
                            @csrf
                            @method('put')

                            @include('alerts.success')

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label>{{ _('Name') }}</label>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                <label>{{ _('Username') }}</label>
                                <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ _('Username') }}" value="{{ old('username', auth()->user()->username) }}">
                                @include('alerts.feedback', ['field' => 'username'])
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label>{{ _('Email') }}</label>
                            <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('email') }}" value="{{ old('email', auth()->user()->email) }}">
                            </div>
                            @include('alerts.feedback', ['field' => 'email'])
                            <div class="form-check form-check-inline ">
                                <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                    <label>{{ _('Phone number') }}</label>
                                    <input id="tel_phone" type="tel" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('tel_phone', auth()->user()->phone_number) }}">                                    
                                    <input type="hidden" id="phone_number" name="phone_number" />
                                    <span id="valid-msg" class="hide"></span>
                                    <span id="error-msg" class="hide"></span>
                                    @include('alerts.feedback', ['field' => 'phone_number'])
                                </div>
                            </div>
                            <div class="form-check form-check-inline">                                    
                                <div class="form-group pl-3{{ $errors->has('birth_date') ? ' has-danger' : '' }}">
                                    <label>{{ _('Birth Date') }}</label>
                                    <input type="date" name="birth_date" 
                                        class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ _('Name') }}" 
                                        value="{{ old('birth_date', auth()->user()->birth_date) }}"
                                        max="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d', strtotime('-100 years')) }}">
                                    @include('alerts.feedback', ['field' => 'birth_date'])
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('address_line_1') ? ' has-danger' : '' }}">
                                <label>{{ _('Address Line 1') }}</label>
                                <input type="text" name="address_line_1" class="form-control{{ $errors->has('address_line_1') ? ' is-invalid' : '' }}" placeholder="{{ _('Address Line 1') }}" value="{{ old('address_line_1', auth()->user()->address_line_1) }}">
                                @include('alerts.feedback', ['field' => 'address_line_1'])
                            </div>
                            <div class="form-group {{ $errors->has('address_line_2') ? ' has-danger' : '' }}">
                                <label>{{ _('Address Line 2') }}</label>
                                <input type="text" name="address_line_2" class="form-control{{ $errors->has('address_line_2') ? ' is-invalid' : '' }}" placeholder="{{ _('Address Line 2') }}" value="{{ old('address_line_2', auth()->user()->address_line_2) }}">
                                @include('alerts.feedback', ['field' => 'address_line_2'])
                            </div>
                            <div class="d-block">
                                <div class=" form-check form-check-inline ">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label>{{ _('City') }}</label>
                                        <input type="text" name="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ _('City') }}" value="{{ old('city', auth()->user()->city) }}">
                                        @include('alerts.feedback', ['field' => 'city'])
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">

                                    <div class="form-group pl-3{{ $errors->has('state') ? ' has-danger' : '' }}">
                                        <label>{{ _('State') }}</label>
                                        <input type="text" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ _('State') }}" value="{{ old('state', auth()->user()->state) }}">
                                        @include('alerts.feedback', ['field' => 'state'])
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">

                                    <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                        <label>{{ _('Country') }}</label>
                                        <input type="text" name="country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ _('Country') }}" value="{{ old('country', auth()->user()->country) }}">
                                        @include('alerts.feedback', ['field' => 'country'])
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">

                                    <div class="form-group pl-3{{ $errors->has('post_code') ? ' has-danger' : '' }}">
                                        <label>{{ _('Post Code') }}</label>
                                        <input type="text" name="post_code" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }}" placeholder="{{ _('Post Code') }}" value="{{ old('post_code', auth()->user()->post_code) }}">
                                        @include('alerts.feedback', ['field' => 'post_code'])
                                    </div>
                                </div>
                                <div class="d-block">
                            <div class="form-check form-check-inline">
                                <div class="form-group{{ $errors->has('annual_income') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="annual_income" class="form-control{{ $errors->has('annual_income') ? ' is-invalid' : '' }}">
                                    
                                    <label>{{ _('Annual Income') }}</label>
                                    <select id="annual_income" name="annual_income" class="form-control">
<<<<<<< HEAD
                                        <option value="${{number_format(25000, 2, '.', ',')}} - ${{number_format(50000, 2, '.', ',')}}" {{ auth()->user()->annual_income == '$'.number_format(25000, 2, '.', ',') .'- $'.number_format(50000, 2, '.', ',') ? 'selected' : '' }}>${{number_format(25000, 2, '.', ',')}} - ${{number_format(50000, 2, '.', ',')}}</option>
                                        <option value="${{number_format(50000, 2, '.', ',')}} - ${{number_format(100000, 2, '.', ',')}}" {{ auth()->user()->annual_income == '$'.number_format(50000, 2, '.', ',').' - $'.number_format(100000, 2, '.', ',') ? 'selected' : '' }}>${{number_format(50000, 2, '.', ',')}} - ${{number_format(100000, 2, '.', ',')}}</option>
                                        <option value="${{number_format(100000, 2, '.', ',')}} - ${{number_format(200000, 2, '.', ',')}}" {{ auth()->user()->annual_income == '$'.number_format(100000, 2, '.', ',').' - $'.number_format(200000, 2, '.', ',') ? 'selected' : '' }}>${{number_format(100000, 2, '.', ',')}} - ${{number_format(200000, 2, '.', ',')}}</option>
                                        <option value="${{number_format(200000, 2, '.', ',')}} - ${{number_format(1000000, 2, '.', ',')}}" {{ auth()->user()->annual_income == '$'.number_format(200000, 2, '.', ',').'- $'.number_format(1000000, 2, '.', ',') ? 'selected' : '' }}>${{number_format(200000, 2, '.', ',')}} - ${{number_format(1000000, 2, '.', ',')}}</option>
                                        <option value="OVER ${{number_format(1000000, 2, '.', ',')}}" {{ auth()->user()->annual_income == 'OVER $'.number_format(1000000, 2, '.', ',') ? 'selected' : '' }}>OVER ${{number_format(1000000, 2, '.', ',')}}</option>
                                    </select>
=======
    <option value="$25,000.00 - $50,000.00" 
        {{ auth()->user()->annual_income == '$25,000.00 - $50,000.00' ? 'selected' : '' }}>
        $25,000.00 - $50,000.00
    </option>
    <option value="$50,000.00 - $100,000.00" 
        {{ auth()->user()->annual_income == '$50,000.00 - $100,000.00' ? 'selected' : '' }}>
        $50,000.00 - $100,000.00
    </option>
    <option value="$100,000.00 - $200,000.00" 
        {{ auth()->user()->annual_income == '$100,000.00 - $200,000.00' ? 'selected' : '' }}>
        $100,000.00 - $200,000.00
    </option>
    <option value="$200,000.00 - $1,000,000.00" 
        {{ auth()->user()->annual_income == '$200,000.00 - $1,000,000.00' ? 'selected' : '' }}>
        $200,000.00 - $1,000,000.00
    </option>
    <option value="OVER $1,000,000.00" 
        {{ auth()->user()->annual_income == 'OVER $1,000,000.00' ? 'selected' : '' }}>
        OVER $1,000,000.00
    </option>
</select>
>>>>>>> d00f9ff (Updated PMS backup from external hard drive)
                                    @include('alerts.feedback', ['field' => 'annual_income'])
                                </div>
                            </div>

                            <div class="form-check form-check-inline pl-5">
                                <div class="form-group{{ $errors->has('liquid_net_worth') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="liquid_net_worth" class="form-control{{ $errors->has('liquid_net_worth') ? ' is-invalid' : '' }}">
                                    
                                    <label>{{ _('Liquid Net Worth') }}</label>
                                    <select id="liquid_net_worth" name="liquid_net_worth" class="form-control">
                                        <option value="$25,000 - $50,000" {{ auth()->user()->liquid_net_worth == '$25,000 - $50,000' ? 'selected' : '' }}>$25,000 - $50,000</option>
                                        <option value="$50,000 - $100,000" {{ auth()->user()->liquid_net_worth == '$50,000 - $100,000' ? 'selected' : '' }}>$50,000 - $100,000</option>
                                        <option value="$100,000 - $200,000" {{ auth()->user()->liquid_net_worth == '$100,000 - $200,000' ? 'selected' : '' }}>$100,000 - $200,000</option>
                                        <option value="$200,000 - $1,000,000" {{ auth()->user()->liquid_net_worth == '$200,000 - $1,000,000' ? 'selected' : '' }}>$200,000 - $1,000,000</option>
                                        <option value="OVER $1,000,000" {{ auth()->user()->liquid_net_worth == 'OVER $1,000,000' ? 'selected' : '' }}>OVER $1,000,000</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'liquid_net_worth'])
                                </div>
                            </div>
                            </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>
            @endif

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
                                {{-- <h5 class="title">{{ auth()->user()->username }}</h5> --}}
                            </a>
                            <p class="description">
                                {{ auth()->user()->name }}
                            </p>
                        </div>
                    </p>
                    <div class="card-description text-center">
                        <b>Email </b>{{ auth()->user()->email }}
                        <br>
                        <b>Phone Number: </b>{{ auth()->user()->phone_number }}
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

        document.addEventListener("DOMContentLoaded", function () {
            let telPhoneInput = document.getElementById("tel_phone");
            let phoneNumberInput = document.getElementById("phone_number");

            // Set default value when page loads
            phoneNumberInput.value = telPhoneInput.value;

            // Update phone_number when tel_phone is changed
            telPhoneInput.addEventListener("input", function () {
                phoneNumberInput.value = this.value;
            });
        });


        $('#profile').on('change', function() {
            let formData = new FormData();
            if ($('#profile')[0].files.length > 0) {
                formData.append('profile_image', $('#profile')[0].files[0]);
            }
            $.ajax({
                type: 'POST',
                url: '{{route("profile.image")}}',
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
