@inject('userService', 'App\Services\UserService')
@inject('holdingService', 'App\Services\HoldingService')

@extends('layouts.app', ['page' => __('View User'), 'pageSlug' => 'activeUsers'])
@section('content')
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="title"># {{ $user->id }} - {{ $user->name }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            @include('users._card', ['user' => $user, 'show_user_info' => false])
            @include('holdings.overview', ['user' => $user])
        </div>
        <div class="col-md-9">
            @include('widgets.numbers.overview', ['user' => $user])
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header clearfix">
                            <div class="float-left">
                                <h3 class="card-title">Holdings</h3>
                            </div>
                            <div class="float-right">
                                <a href="/holdings/create?user_id={{ $user->id }}" class="btn btn-sm btn-success">Add
                                    Holding</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $holdings = $holdingService->recentUserHoldings($user->id);
                            ?>
                            @include('holdings.recent', ['holdings' => $holdings])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
