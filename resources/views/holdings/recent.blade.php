@inject('holdingService', 'App\Services\HoldingService')
<div class="table-responsive">
    <table class="table tablesorter hover">
        <thead class=" text-primary">
            <tr>
                <th scope="col">Transaction No.</th>
                <th scope="col">Symbol</th>
                <th scope="col">Stock Name</th>
                <th scope="col">Trade Date</th>
                <th scope="col">No. of shares</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Type</th>
                <th scope="col">Status</th>
                <th scope="col">Total Volume</th>
                <th scope="col">PnL</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($holdings as $holding)
                <tr>
                    <td><a
                            href="{{ route('holdings.show', ['holding' => $holding]) }}">{{ $holding->transaction_no }}</a>
                    </td>
                    <td>{{ $holding->symbol }}</td>
                    <td>{{ $holding->stock_name }}</td>
                    <td>{{ $holding->trade_date }}</td>
                    <td>
                        {{ number_format($holding->no_of_shares, 2) }}
                    </td>
                    <td>
                        {{ number_format($holding->unit_price, 2) }}
                    </td>
                    <td>{{ strtoupper($holding->type) }}</td>
                    <td>
                        @if ($holding->status === 'paid')
                            SETTLED
                        @else
                            {{ strtoupper($holding->status) }}
                        @endif
                    </td>
                    <td>
                        {{ number_format($holding->total, 2) }}
                    </td>
                    <td>
                        {{ $holdingService->formatPnL($holding) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <h6>Nothing Found</h6>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12 pull-right">
        <a href="/holdings?client_id={{ $user->id }}" class="btn btn-primary"><strong>View All</strong></a>
    </div>
</div>
