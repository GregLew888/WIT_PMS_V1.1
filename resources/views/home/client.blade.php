@inject('priceService', 'App\Services\PriceUpdateService')
@inject('holdingService', 'App\Services\HoldingService')
<?php
$marketOverview = $priceService->getMarketFeed($user->id);
$portfolio = $marketOverview['portfolio'];
?>
@extends('layouts.app', ['pageSlug' => 'dashboard'])
@section('content')
    <div class="main-content">
        <div class="bg-gradient-primary pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase highlight-text mb-0">Account Balance
                                            </h5>
                                            <span id="account-balance-val"
                                                class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['total'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase highlight-text  mb-0">Cash Balance</h5>
                                            <span
                                                class="h2 font-weight-bold mb-0">${{ number_format($data['cash_balance'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase highlight-text mb-0">Outstanding
                                                Balance</h5>
                                            <span
                                                class="h2 font-weight-bold mb-0">${{ number_format($data['outstanding_balance'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase highlight-text  mb-0">Margin Amount
                                            </h5>
                                            <span
                                                class="h2 font-weight-bold mb-0">${{ number_format($data['margin_amount'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
    </div>
    <div class="container d-flex justify-content-end">
        <div class="mt-5 p-4">
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Transactions</h4>
                    <div class="card-body" id="realtime-transaction-feed">
                        @include('widgets.holdings.transactions-table', ['holdings' => $holdings])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
