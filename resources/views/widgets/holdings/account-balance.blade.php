@inject('priceService', 'App\Services\PriceUpdateService')
<?php
$marketOverview = $priceService->getMarketFeed($user->id);
$portfolio = $marketOverview['portfolio'];
?>

<div class="row">
    <div class="col-md-12">
        <div class="card holding-overview-card card-stats card mb-4 mb-xl-0">
            <div class="card-body">
                <div class="h-100 card-account-balance vcenter-item">
                    <div class="account-balance">
                        <h3 class="text-uppercase font-weight-bold mb-10">Account Balance
                        </h3>
                        <h1 class="font-weight-bold" id="account-balance-val">
                            ${{ number_format($marketOverview['total'], 2, '.', ',') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
