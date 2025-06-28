@inject('priceService', 'App\Services\PriceUpdateService')
<?php
$marketOverview = $priceService->getMarketFeed($user->id);
$portfolio = $marketOverview['portfolio'];
?>
<input type="hidden" name="hd_account_balance" id="hd_account_balance"
    value="{{ number_format($marketOverview['total'], 2, '.', ',') }}" />
<div class="row">
    <div class="col-md-12">
        <div class="card holding-overview-card card-stats">
            <div class="card-header card-stats">
                <p class="tile-subtitle-p tile-subtitle-footer pull-right"><button class="btn btn-sm"
                        id="btn-refresh-feed"><i class="fa fa-sync"></i></button></p>
            </div>
            <div class="card-body">
                <div class="fixTableHead">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-25">Symbol</th>
                                <th class="w-25 text-right">Quantity</th>
                                <th class="w-25 text-right">Price</th>
                                <th class="w-25 text-right">Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($portfolio as $symbol => $item)
                                <tr class="symbol-row" data-symbol="{{ $symbol }}">
                                    <td>{{ $symbol }}</td>
                                    <td class="text-right">{{ number_format($item['qty'], 0) }}</td>
                                    <td class="text-right price-col">{{ number_format($item['price'], 2) }}</td>
                                    <td class="text-right total-col">{{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @empty
                              <tr>
    <td colspan="4" class="text-center py-5">
        <div style="max-width: 600px; margin: auto;">
            <h5 class="text-secondary font-weight-bold" style="margin-bottom: 16px;">No Holdings Available</h5>
            <p class="text-muted mb-0" style="font-size: 0.95rem; margin-top: 10px;">
                Your account has not yet reflected any holdings. Portfolio data will appear here as transactions are recorded.
                <br>
                For assistance, please reach out to your Relationship Manager.
            </p>
        </div>
    </td>
</tr>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
