{{ $holdings->appends(request()->query())->links() }}
@include('alerts.success')
<div class="table-responsive">
    <table class="table tablesorter hover" id="example">
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
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($holdings as $holding)
                @if (!isset($holding->client->id))
                    @continue
                @endif
                <tr>
                    @if (auth()->user()->hasAnyRole(['admin']))
                        <td>{{ $holding->client->name }}
                            <p class="small text-muted">
                                #{{ $holding->client->id ?? '' }}
                                <i class="fa fa-at">{{ $holding->client->email }}</i>
                            </p>
                        </td>
                    @endif
                    <td>{{ $holding->transaction_no }}
                    </td>
                    <td>{{ $holding->symbol }}</td>
                    <td>{{ $holding->stock_name }}</td>
                    <td>{{ $holding->trade_date }}
                    </td>
                    <td>
                        {{ number_format($holding->no_of_shares, 2) }}
                    </td>
                    <td>
                        {{ number_format($holding->unit_price, 2) }}
                    </td>
                    <td>{{ strtoupper($holding->type) }}</td>
                    <td>
                        @if ($holding->status === 'paid')
                            <span class="badge badge-settled badge-pill">
                                SETTLED
                            </span>
                        @else
                            <span class="badge badge-pill badge-info">{{ strtoupper($holding->status) }}</span>
                        @endif
                    </td>
                    <td>
                        {{ number_format($holding->total, 2) }}
                    </td>
                    <td>
                        {{ $holdingService->formatPnl($holding) }}
                    </td>
                    <td class="td-actions text-right">
                        @if (auth()->user()->hasAnyRole(['admin']))
                            <a href="{{ route('holdings.show', ['holding' => $holding]) }}"
                                class="btn btn-default btn-sm mt-1" data-holdingid="{{ $holding->id }}">
                                View
                                </button>
                        @endif
                    </td>
                </tr>
            @empty
                <h6>Nothing Found</h6>
            @endforelse
        </tbody>
    </table>
    {{ $holdings->appends(request()->query())->links() }}
</div>
