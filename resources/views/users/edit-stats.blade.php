@extends('layouts.app', ['page' => __('Site Setting'), 'pageSlug' => $user->status ? 'activeUsers' : 'users'])
@inject('userService', 'App\Services\UserService')
<?php
$userStats = $userService->getClientStats($user);
?>
@section('content')
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group btn-sm btn-toolbar pull-right">
                        <a href="{{ route('users.view', ['id' => $user->id]) }}" class="btn btn-light">Back to Customer</a>
                    </div>
                    <h3 class="title"># {{ $user->id }} - {{ $user->name }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('User Stats') }}</h5>
                </div>

                <form method="post" action="{{ route('users.update-stats', $user->id) }}" autocomplete="off">
                    <div class="card-body">
                        @include('alerts.success')
                        @csrf
                        @method('put')

                        <div class="d-block">
                            <div class=" form-check form-check-inline ">
                                <div class="form-group{{ $errors->has('account_balance') ? ' has-danger' : '' }}">
                                    <label>{{ _('Capital Invested') }}</label>
                                    <input type="text" name="account_balance"
                                        class="form-control{{ $errors->has('account_balance') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('$0.00') }}"
                                        value="{{ old('account_balance', $userStats->account_balance) }}">
                                    @include('alerts.feedback', ['field' => 'account_balance'])
                                </div>
                            </div>
                            <div class=" form-check form-check-inline ">
                                <div class="form-group pl-3{{ $errors->has('cash_balance') ? ' has-danger' : '' }}">
                                    <label>{{ _('Cash Balance') }}</label>
                                    <input type="text" name="cash_balance"
                                        class="form-control{{ $errors->has('cash_balance') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('$0.00') }}"
                                        value="{{ old('cash_balance', $userStats->cash_balance) }}">
                                    @include('alerts.feedback', ['field' => 'cash_balance'])
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class=" form-check form-check-inline ">
                                <div class="form-group{{ $errors->has('outstanding_balance') ? ' has-danger' : '' }}">
                                    <label>{{ _('Outstanding balance') }}</label>
                                    <input type="text" name="outstanding_balance"
                                        class="form-control{{ $errors->has('outstanding_balance') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('$0.00') }}"
                                        value="{{ old('outstanding_balance', $userStats->outstanding_balance) }}">
                                    @include('alerts.feedback', ['field' => 'outstanding_balance'])
                                </div>
                            </div>
                            <div class="form-check form-check-inline">

                                <div class="form-group pl-3{{ $errors->has('margin_amount') ? ' has-danger' : '' }}">
                                    <label>{{ _('Margin amount') }}</label>
                                    <input type="text" name="margin_amount"
                                        class="form-control{{ $errors->has('margin_amount') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('$0.00') }}"
                                        value="{{ old('margin_amount', $userStats->margin_amount) }}">
                                    @include('alerts.feedback', ['field' => 'margin_amount'])
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Save') }}</button>
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
                        <b>Phone Number: </b>{{ $user->phone_number }}<br>
                        <b>Capital Invested: </b>${{ number_format($userStats->account_balance, 2, '.', ',') }}<br>
                        <b>Cash Balance: </b>${{ number_format($userStats->cash_balance, 2, '.', ',') }}<br>
                        <b>Outstanding Balance: </b>${{ number_format($userStats->outstanding_balance, 2, '.', ',') }}<br>
                        <b>Margin Amount: </b>${{ number_format($userStats->margin_amount, 2, '.', ',') }}<br>
                    </div>
                    {{-- <div class="card-description">
                        <h4>Calculated Stats</h4>
                        <b>Account Balance:  </b>${{ $stats->account_balance }}<br>
                        <b>Cash Balance:  </b>${{ $stats->cash_balance }}<br>
                        <b>Outstanding Balance:  </b>${{ $stats->outstanding_balance }}<br>
                        <b>Margin Amount:  </b>${{ $stats->margin_amount }}<br>
                    </div> --}}
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

            });
        </script>
    @endpush
@endsection
