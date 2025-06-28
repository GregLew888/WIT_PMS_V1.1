@extends('layouts.app', ['page' => __('Create Client'), 'pageSlug' => 'activeUsers'])
@section('css')
    <style>
        .selectize-input.items.full.has-options.has-items {
            min-width: 273px;
        }

        .item {
            letter-spacing: 1px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Register New Client') }}</h5>
                </div>

                <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf

                        @include('alerts.success')
                        <div class=" mt-5 form-group{{ $errors->has('profile_image') ? ' has-danger' : '' }}">
                            <div class="profile-pic">
                                <label class="-label" for="profile">
                                    <span class="tim-icons icon-camera-18"></span>
                                    <span>Change Image</span>
                                </label>
                                <input id="profile" type="file" name="profile_image" />
                                <img src="{{ asset('white/img/default-avatar.jpg') }}" id="output" width="200" />
                            </div>
                            @include('alerts.feedback', ['field' => 'profile_image'])
                        </div>
                        <div class="col-md-5 form-check form-check-inline">
                            <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label>{{ _('Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ _('name') }}" value="{{ old('name') }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                        </div>
                        <div class="col-md-5 form-check form-check-inline">
                            <div class="col-md-12 form-group {{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                <label>{{ _('Number') }}</label>
                                <input id="phone_number" name="phone_number" type="text"
                                    class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                    placeholder="" value="{{ old('phone_number') }}">
                                <span id="valid-msg" class="hide"></span>
                                <span id="error-msg" class="hide"></span>
                                @include('alerts.feedback', ['field' => 'phone_number'])
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="col-md-5 form-check form-check-inline ">
                                <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label>{{ _('Email') }}</label>
                                    <input type="text" name="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('email') }}" value="{{ old('email') }}" autocomplete="off">
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline ">
                                <div class="col-md-12 form-group pl-3{{ $errors->has('username') ? ' has-danger' : '' }}">
                                    <label>{{ _('Username') }}</label>
                                    <input type="text" name="username"
                                        class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('username') }}" value="{{ old('username') }}"
                                        autocomplete="off">
                                    @include('alerts.feedback', ['field' => 'username'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline ">
                                <div class="col-md-12 form-group {{ $errors->has('birth_date') ? ' has-danger' : '' }}">
                                    <label>{{ _('Birth Date') }}</label>
                                    <input type="date" name="birth_date"
                                        class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Name') }}"
                                        value="{{ old('birth_date', now()->format('Y-m-d')) }}">
                                    @include('alerts.feedback', ['field' => 'birth_date'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group pl-3 {{ $errors->has('address_line_1') ? ' has-danger' : '' }}">
                            <label>{{ _('Address Line 1') }}</label>
                            <input type="text" name="address_line_1"
                                class="form-control{{ $errors->has('address_line_1') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Address Line 1') }}" value="{{ old('address_line_1') }}">
                            @include('alerts.feedback', ['field' => 'address_line_1'])
                        </div>
                        <div class="form-group pl-3 {{ $errors->has('address_line_2') ? ' has-danger' : '' }}">
                            <label>{{ _('Address Line 2') }}</label>
                            <input type="text" name="address_line_2"
                                class="form-control{{ $errors->has('address_line_2') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Address Line 2') }}" value="{{ old('address_line_2') }}">
                            @include('alerts.feedback', ['field' => 'address_line_2'])
                        </div>
                        <div class="d-block">
                            <div class="col-md-5 form-check form-check-inline ">
                                <div class="col-md-12 form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                    <label>{{ _('City') }}</label>
                                    <input type="text" name="city"
                                        class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('City') }}" value="{{ old('city') }}">
                                    @include('alerts.feedback', ['field' => 'city'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline">

                                <div class="col-md-12 form-group {{ $errors->has('state') ? ' has-danger' : '' }}">
                                    <label>{{ _('State') }}</label>
                                    <input type="text" name="state"
                                        class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('State') }}" value="{{ old('state') }}">
                                    @include('alerts.feedback', ['field' => 'state'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline">

                                <div class="col-md-12 form-group {{ $errors->has('country') ? ' has-danger' : '' }}">
                                    <label>{{ _('Country') }}</label>
                                    <input type="text" name="country"
                                        class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Country') }}" value="{{ old('country') }}">
                                    @include('alerts.feedback', ['field' => 'country'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline">

                                <div class="col-md-12 form-group{{ $errors->has('post_code') ? ' has-danger' : '' }}">
                                    <label>{{ _('Post Code') }}</label>
                                    <input type="text" name="post_code"
                                        class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Post Code') }}" value="{{ old('post_code') }}">
                                    @include('alerts.feedback', ['field' => 'post_code'])
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="col-md-5 form-check form-check-inline">
                                <div class="col-md-12 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{ _('Password') }}</label>
                                    <input type="password" id="textPassword" name="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('password') }}" value="{{ old('password') }}"
                                        autocomplete="new-password">
                                    <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon"
                                        style="margin-top: -25px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                                    @include('alerts.feedback', ['field' => 'password'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline">

                                <div
                                    class="col-md-12 form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <label>{{ _('Confirm Password') }}</label>
                                    <input type="password" id="textPasswordc" name="password_confirmation"
                                        class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('password confirmation') }}"
                                        value="{{ old('password_confirmation') }}">
                                    <span id="toggle_pwdc" class="fa fa-fw fa-eye field_icon"
                                        style="margin-top: -25px;margin-right: 0px;cursor: pointer;z-index: 2;position: absolute;right: 20px;"></span>
                                    @include('alerts.feedback', ['field' => 'password_confirmation'])
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="col-md-5 form-check form-check-inline">
                                <div class="col-md-12 form-group{{ $errors->has('annual_income') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="annual_income"
                                        class="form-control{{ $errors->has('annual_income') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Annual Income') }}</label>
                                    <select id="annual_income" name="annual_income">

                                        <!-- <option value="moderator" >Moderator</option> -->
                                        <option
                                            value="${{ number_format(25000, 2, '.', ',') }} - ${{ number_format(50000, 2, '.', ',') }}">
                                            ${{ number_format(25000, 2, '.', ',') }} -
                                            ${{ number_format(50000, 2, '.', ',') }}</option>
                                        <option
                                            value="${{ number_format(50000, 2, '.', ',') }} - ${{ number_format(100000, 2, '.', ',') }}">
                                            ${{ number_format(50000, 2, '.', ',') }} -
                                            ${{ number_format(100000, 2, '.', ',') }}</option>
                                        <option
                                            value="${{ number_format(100000, 2, '.', ',') }} - ${{ number_format(200000, 2, '.', ',') }}">
                                            ${{ number_format(100000, 2, '.', ',') }} -
                                            ${{ number_format(200000, 2, '.', ',') }}</option>
                                        <option
                                            value="${{ number_format(200000, 2, '.', ',') }} - ${{ number_format(1000000, 2, '.', ',') }}">
                                            ${{ number_format(200000, 2, '.', ',') }} -
                                            ${{ number_format(1000000, 2, '.', ',') }}</option>
                                        <option value="OVER ${{ number_format(1000000, 2, '.', ',') }}">OVER
                                            ${{ number_format(1000000, 2, '.', ',') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'annual_income'])
                                </div>
                            </div>
                            <div class="col-md-5 form-check form-check-inline ">
                                <div
                                    class="col-md-12 form-group{{ $errors->has('liquid_net_worth') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="liquid_net_worth"
                                        class="form-control{{ $errors->has('liquid_net_worth') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Liquid Net Worth') }}</label>
                                    <select id="liquid_net_worth" name="liquid_net_worth">

                                        <!-- <option value="moderator" >Moderator</option> -->
                                        <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                                        <option value="$50,000 - $100,000">$50,000 - $100,000</option>
                                        <option value="$100,000 - $200,000">$100,000 - $200,000</option>
                                        <option value="$200,000 - $1,000,000">$200,000 - $1,000,000</option>
                                        <option value="OVER $1,000,000">OVER $1,000,000</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'liquid_net_worth'])
                                </div>
                            </div>
                        </div>
                        <div class="form-group px-3 {{ $errors->has('role') ? ' has-danger' : '' }}">
                            <input type="hidden" name="role"
                                class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">

                            <label>{{ _('Role') }}</label>
                            <select id="role" name="role[]">

                                <!-- <option value="moderator" >Moderator</option> -->
                                <option value="client">Client</option>
                                <option value="admin">Admin</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'role'])
                        </div>
                    </div>
            </div>
                    </div>
                    <div class="card-footer">
                <button type="submit" class="btn btn-fill btn-success">{{ _('Register New Client') }}</button>
            </div>
        </form>
    </div>
</div>

@push('js')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#role').selectize({ placeholder: 'Select Role' });
            $('#annual_income').selectize({ placeholder: 'Annual Income' });
            $('#liquid_net_worth').selectize({ placeholder: 'Liquid Net Worth' });

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

            @if (session('status'))
                Swal.fire({
                    icon: 'info',
                    title: '{{ session("status") }}',
                    text: 'The client record has been successfully processed.',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#2c3e50'
                });
            @endif
        });
    </script>
@endpush

@endsection