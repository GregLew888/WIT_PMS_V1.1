@inject('userService', 'App\Services\UserService')
@inject('holdingService', 'App\Services\HoldingService')
@inject('priceService', 'App\Services\PriceUpdateService')
<?php
$marketOverview = $priceService->getMarketFeed($user->id);
$portfolio = $marketOverview['portfolio'];
?>
<div class="row">
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase highlight-text mb-0">Account Balance
                        </h5>
                        <span id="account-balance-val"
                            class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['total'], 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase highlight-text mb-0">Invested Capital
                        </h5>
                        <span id="account-balance-val"
                            class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['invested'], 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase highlight-text mb-0">Total Cover
                        </h5>
                        <span id="account-balance-val"
                            class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['cover'], 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase highlight-text mb-0">Total Credit
                        </h5>
                        <span id="account-balance-val"
                            class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['credit'], 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase highlight-text mb-0">Total Widthdraw
                        </h5>
                        <span id="account-balance-val"
                            class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['withdrawal'], 2, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
