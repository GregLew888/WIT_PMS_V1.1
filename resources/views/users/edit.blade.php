@extends('layouts.app', ['page' => __('Site Setting'), 'pageSlug' => $user->status ? 'activeUsers' : 'users'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('User Update') }}</h5>
                </div>
                <form method="post" action="{{ route('users.update', $user->id) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        @include('alerts.success')
                        @csrf
                        @method('put')

                        <div class=" mt-5 form-group{{ $errors->has('profile_image') ? ' has-danger' : '' }}">
                            <div class="profile-pic">
                                <label class="-label" for="profile">
                                    <span class="tim-icons icon-camera-18"></span>
                                    <span>Change Image</span>
                                </label>
                                <input id="profile" type="file" name="profile_image" />
                                <img src="{{ $user->getFirstMediaUrl('profile_image') }}" id="output" width="200" />
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label>{{ _('Name') }}</label>
                            <input type="text" name="name"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Name') }}" value="{{ old('name', $user->name) }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <label>{{ _('Username') }}</label>
                            <input type="text" name="username"
                                class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Username') }}" value="{{ old('username', $user->username) }}">
                            @include('alerts.feedback', ['field' => 'username'])
                        </div>
                        <div class="d-block">
                            <div class=" form-check form-check-inline ">
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label>{{ _('Email') }}</label>
                                    <input type="text" name="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('email') }}" value="{{ old('email', $user->email) }}">
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                            </div>
                            <div class=" form-check form-check-inline ">
                                <div class="form-group pl-3{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                    <label>{{ _('Phone number') }}</label>
                                    <input id="phone_number" name="phone_number" type="text"
                                        class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                        placeholder="" value="{{ old('tel_phone', $user->phone_number) }}">
                                    <span id="valid-msg" class="hide"></span>
                                    <span id="error-msg" class="hide"></span>
                                    @include('alerts.feedback', ['field' => 'phone_number'])
                                </div>
                            </div>
                            <div class=" form-check form-check-inline ">
                                <div class="form-group pl-3{{ $errors->has('birth_date') ? ' has-danger' : '' }}">
                                    <label>{{ _('Birth Date') }}</label>
                                    <input type="date" name="birth_date"
                                        class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Name') }}"
                                        value="{{ old('birth_date', $user->birth_date) }}">
                                    @include('alerts.feedback', ['field' => 'birth_date'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address_line_1') ? ' has-danger' : '' }}">
                            <label>{{ _('Address Line 1') }}</label>
                            <input type="text" name="address_line_1"
                                class="form-control{{ $errors->has('address_line_1') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Address Line 1') }}"
                                value="{{ old('address_line_1', $user->address_line_1) }}">
                            @include('alerts.feedback', ['field' => 'address_line_1'])
                        </div>
                        <div class="form-group {{ $errors->has('address_line_2') ? ' has-danger' : '' }}">
                            <label>{{ _('Address Line 2') }}</label>
                            <input type="text" name="address_line_2"
                                class="form-control{{ $errors->has('address_line_2') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Address Line 2') }}"
                                value="{{ old('address_line_2', $user->address_line_2) }}">
                            @include('alerts.feedback', ['field' => 'address_line_2'])
                        </div>
                        <div class="d-block">
                            <div class=" form-check form-check-inline ">
                                <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                    <label>{{ _('City') }}</label>
                                    <input type="text" name="city"
                                        class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('City') }}" value="{{ old('city', $user->city) }}">
                                    @include('alerts.feedback', ['field' => 'city'])
                                </div>
                            </div>
                            <div class="form-check form-check-inline">

                                <div class="form-group pl-3{{ $errors->has('state') ? ' has-danger' : '' }}">
                                    <label>{{ _('State') }}</label>
                                    <input type="text" name="state"
                                        class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('State') }}" value="{{ old('state', $user->state) }}">
                                    @include('alerts.feedback', ['field' => 'state'])
                                </div>
                            </div>
                            <div class="form-check form-check-inline">

                                <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                    <label>{{ _('Country') }}</label>
                                    <input type="text" name="country"
                                        class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Country') }}" value="{{ old('country', $user->country) }}">
                                    @include('alerts.feedback', ['field' => 'country'])
                                </div>
                            </div>
                            <div class="form-check form-check-inline">

                                <div class="form-group pl-3{{ $errors->has('post_code') ? ' has-danger' : '' }}">
                                    <label>{{ _('Post Code') }}</label>
                                    <input type="text" name="post_code"
                                        class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Post Code') }}"
                                        value="{{ old('post_code', $user->post_code) }}">
                                    @include('alerts.feedback', ['field' => 'post_code'])
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="form-check form-check-inline">
                                <div class="form-group{{ $errors->has('annual_income') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="annual_income"
                                        class="form-control{{ $errors->has('annual_income') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Annual Income') }}</label>
                                    <select id="annual_income" name="annual_income" class="form-control">
<<<<<<< HEAD
                                        <option value="$25,000 - $50,000"
                                            {{ $user->annual_income == '$25,000 - $50,000' ? 'selected' : '' }}>$25,000 -
                                            $50,000</option>
                                        <option value="$50,000 - $100,000"
                                            {{ $user->annual_income == '$50,000 - $100,000' ? 'selected' : '' }}>$50,000 -
                                            $100,000</option>
                                        <option value="$100,000 - $200,000"
                                            {{ $user->annual_income == '$100,000 - $200,000' ? 'selected' : '' }}>$100,000
                                            - $200,000</option>
                                        <option value="$200,000 - $1,000,000"
                                            {{ $user->annual_income == '$200,000 - $1,000,000' ? 'selected' : '' }}>
                                            $200,000 - $1,000,000</option>
                                        <option value="OVER $1,000,000"
                                            {{ $user->annual_income == 'OVER $1,000,000' ? 'selected' : '' }}>OVER
                                            $1,000,000</option>
                                    </select>
=======
    <option value="${{number_format(25000, 2, '.', ',')}} - ${{number_format(50000, 2, '.', ',')}}"
        {{ $user->annual_income == '$25,000.00 - $50,000.00' ? 'selected' : '' }}>
        ${{number_format(25000, 2, '.', ',')}} - ${{number_format(50000, 2, '.', ',')}}
    </option>

    <option value="${{number_format(50000, 2, '.', ',')}} - ${{number_format(100000, 2, '.', ',')}}"
        {{ $user->annual_income == '$50,000.00 - $100,000.00' ? 'selected' : '' }}>
        ${{number_format(50000, 2, '.', ',')}} - ${{number_format(100000, 2, '.', ',')}}
    </option>

    <option value="${{number_format(100000, 2, '.', ',')}} - ${{number_format(200000, 2, '.', ',')}}"
        {{ $user->annual_income == '$100,000.00 - $200,000.00' ? 'selected' : '' }}>
        ${{number_format(100000, 2, '.', ',')}} - ${{number_format(200000, 2, '.', ',')}}
    </option>

    <option value="${{number_format(200000, 2, '.', ',')}} - ${{number_format(1000000, 2, '.', ',')}}"
        {{ $user->annual_income == '$200,000.00 - $1,000,000.00' ? 'selected' : '' }}>
        ${{number_format(200000, 2, '.', ',')}} - ${{number_format(1000000, 2, '.', ',')}}
    </option>

    <option value="OVER ${{number_format(1000000, 2, '.', ',')}}"
        {{ $user->annual_income == 'OVER $1,000,000.00' ? 'selected' : '' }}>
        OVER ${{number_format(1000000, 2, '.', ',')}}
    </option>
</select>
>>>>>>> d00f9ff (Updated PMS backup from external hard drive)
                                    @include('alerts.feedback', ['field' => 'annual_income'])
                                </div>
                            </div>

                            <div class="form-check form-check-inline pl-5">
                                <div class="form-group{{ $errors->has('liquid_net_worth') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="liquid_net_worth"
                                        class="form-control{{ $errors->has('liquid_net_worth') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Liquid Net Worth') }}</label>
                                    <select id="liquid_net_worth" name="liquid_net_worth" class="form-control">
                                        <option value="$25,000 - $50,000"
                                            {{ $user->liquid_net_worth == '$25,000 - $50,000' ? 'selected' : '' }}>$25,000
                                            - $50,000</option>
                                        <option value="$50,000 - $100,000"
                                            {{ $user->liquid_net_worth == '$50,000 - $100,000' ? 'selected' : '' }}>$50,000
                                            - $100,000</option>
                                        <option value="$100,000 - $200,000"
                                            {{ $user->liquid_net_worth == '$100,000 - $200,000' ? 'selected' : '' }}>
                                            $100,000 - $200,000</option>
                                        <option value="$200,000 - $1,000,000"
                                            {{ $user->liquid_net_worth == '$200,000 - $1,000,000' ? 'selected' : '' }}>
                                            $200,000 - $1,000,000</option>
                                        <option value="OVER $1,000,000"
                                            {{ $user->liquid_net_worth == 'OVER $1,000,000' ? 'selected' : '' }}>OVER
                                            $1,000,000</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'liquid_net_worth'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                            {{-- <input type="hidden" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"> --}}

                            <label>{{ _('Status') }}</label>
                            <select id="status" name="status">
                                <option value=""></option>
                                <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>In-Active</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
                        </div>
                        <div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                            <input type="hidden" name="role"
                                class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">

                            <label>{{ _('Role') }}</label>
                            <select id="role" name="role[]">
                                <option value=""></option>
                                <option value="admin" {{ $user->getRoleNames()->first() == 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="client" {{ $user->getRoleNames()->first() == 'client' ? 'selected' : '' }}>
                                    Client</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('User Password') }}</h5>
                </div>
                <form method="post" action="{{ route('users.password', $user->id) }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'local_password_status'])

                        <!-- <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                                            <label>{{ __('Current Password') }}</label>
                                                            <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                                                            @include('alerts.feedback', [
                                                                'field' => 'old_password',
                                                            ])
                                                        </div> -->

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label>{{ __('New Password') }}</label>
                            <input type="password" id="textPassword" name="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                placeholder="{{ __('New Password') }}" value="" required
                                autocomplete="new-password">
                            <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon"
                                style="margin-top: -25px;margin-right: -10px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>

                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm New Password') }}</label>
                            <input type="password" id="textPasswordc" name="password_confirmation" class="form-control"
                                placeholder="{{ __('Confirm New Password') }}" value="" required
                                autocomplete="new-password">
                            <span id="toggle_pwdc" class="fa fa-fw fa-eye field_icon"
                                style="margin-top: -25px;margin-right: -10px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>

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
                            <h5 class="title">{{ $user->name }}</h5>
                        </a>
                        <p class="description">
                            {{ $user->email }}
                        </p>
                    </div>
                    </p>
                    <div class="card-description">
                        <b>Phone Number: </b>{{ $user->phone_number }}<br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {

                $('#role').selectize({
                    placeholder: 'Select Role'
                });
                $('#status').selectize({
                    placeholder: 'Select Client Status'
                });

                $("#profile").change(function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $("#output").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });

            });
        </script>
    @endpush
@endsection
