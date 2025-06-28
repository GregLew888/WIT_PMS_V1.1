@extends('layouts.app', ['page' => __('Holdings'), 'pageSlug' => 'holdings'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title pull-left">
                        <h3 class="title"># {{ $holding->client->id }} - {{ $holding->client->name }}
                            <small class="text-muted">[{{ $holding->id }} - {{ $holding->transaction_no }}]</small>
                        </h3>
                    </div>
                    <div class="btn-toolbar contact-toolbar pull-right">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-sm btn-primary" href="{{ route('holdings.create') }}">Create Holding</a>
                            <a class="btn btn-sm btn-primary" href="{{ route('holdings.index') }}">Back to Holdings</a>
                            <a class="btn btn-sm btn-primary"
                                href="{{ route('users.view', ['id' => $holding->user_id]) }}">Show Customer</a>
                            <a class="btn btn-sm" href="{{ route('holdings.edit', ['holding' => $holding]) }}">Edit</a>
                            <button class="btn btn-sm btn-danger"
                                onclick="confirmHoldingDelete('{{ $holding->id }}')">Delete</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="col-md-6 mb-10">
                        <tr>
                            <th>No. of Shares</th>
                            <th>Unit Price</th>
                            <th>Cost</th>
                            <th>Total</th>
                            <th>PnL</th>
                        </tr>
                        <tr>
                            <td>
                                {{ number_format($holding->no_of_shares, 2) }}
                            </td>
                            <td>
                                {{ number_format($holding->unit_price, 2) }}
                            </td>
                            <td>{{ number_format($holding->purchase, 2) }}</td>
                            <td>{{ number_format($holding->total, 2) }}</td>
                            <td>{{ number_format($holding->profit_loss, 2) }}</td>
                        </tr>
                    </table>
                    <table class="table table-full-width mt-10">
                        <tr>
                            <th>Customer</th>
                            <td>{{ $holding->client->name }}
                                <p class="small text-muted">
                                    #{{ $holding->client->id ?? '' }}
                                    <i class="fa fa-at">{{ $holding->client->email }}</i>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Transaction No</th>
                            <td>{{ $holding->transaction_no }}</td>
                        </tr>
                        <tr>
                            <th>Symbol</th>
                            <td>{{ $holding->symbol }}
                            </td>
                        </tr>
                        <tr>
                            <th>Stock Name</th>
                            <td>{{ $holding->stock_name }}</td>
                        </tr>
                        <tr>
                            <th>Trade Date</th>
                            <td>{{ $holding->trade_date }}</td>
                        </tr>
                        <tr>
                            <th>Transaction Type</th>
                            <td>{{ strtoupper($holding->type) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($holding->status == 'paid')
                                    SETTLED
                                @else
                                    {{ strtoupper($holding->status) }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Holding Status History</h3>
                        <form method="post" action="{{ route('holding_status.change') }}" class="form">
                            @csrf
                            <input type="hidden" name="holding_id" value="{{ $holding->id }}">
                            <div class="form-group col-md-5">
                                <label for="new_status" class="mr-10">Change Status to:</label>
                                <select name="new_status" id="new_status" class="form-control">
                                    <option value="">Select New Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Settled</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="submit" value="Update Status" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @include('holding_history.index', ['holding' => $holding])
                </div>
            </div>
        </div>
    </div>
    @include('holdings.confirm_delete')
@endsection

@push('js')
@endpush
