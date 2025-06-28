@inject('holdingService', 'App\Services\HoldingService')
@inject('priceService', 'App\Services\PriceUpdateService')
<?php
$marketOverview = $priceService->getMarketFeed($user->id);
$portfolio = $marketOverview['portfolio'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="card holding-overview-card">
            <div class="card-header card-stats">
                <h5 class="text-uppercase mb-0">Account Balance
                </h5>
                <span class="h2 font-weight-bold mb-0">${{ number_format($marketOverview['total'], 2, '.', ',') }}</span>
                @role('admin')
                    <div class="btn-group-sm pull-right">
                        <a class="btn btn-small" href="{{ route('holdings.change-overview', ['user' => $user]) }}"><i
                                class="fa fa-pencil-alt"></i> Edit</a>
                    </div>
                @endrole
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-white">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($portfolio as $symbol => $details)
                            <?php
                            $symbolQty = $details['qty'];
                            $price = $details['price'];
                            $total = $details['total'];
                            ?>
                            @if ($symbolQty == 0)
                                @continue
                            @endif
                            <tr>
                                <td>{{ $symbol }}</td>
                                <td class="text-right">{{ number_format($symbolQty, 0) }}</td>
                                <td class="text-right">{{ number_format($price, 2) }}</td>
                                <td class="text-right">{{ number_format($total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <tr>
    <td colspan="12" class="text-center py-5">
        <h5 class="text-muted">No Transactions Available</h5>
        <p class="text-muted mb-0">
            Your portfolio currently does not have any transactions to display.
        </p>
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
