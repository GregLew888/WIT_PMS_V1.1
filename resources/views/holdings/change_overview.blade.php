@extends('layouts.app', ['page' => __('Holding Overview'), 'pageSlug' => 'Holdings Overview'])
@section('content')
    @inject('holdingService', 'App\Services\HoldingService')

    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group btn-sm btn-toolbar pull-right">
                        <a href="{{ route('users.view', ['id' => $user->id]) }}" class="btn btn-light btn-sm">Back to
                            Customer</a>
                        <a href="{{ route('users.edit-stats', ['user' => $user->id]) }}"
                            class="btn btn-light btn-sm">Stats</a>
                    </div>
                    <h3 class="title"># {{ $user->id }} - {{ $user->name }}</h3>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('holdings.do-change-overview', ['user' => $user]) }}" method="post">
        @csrf
        <input type="hidden" name="client_id" value="{{ $user->id }}" />
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group pull-right">
                            <input type="submit" class="btn btn-primary" value="Save" />
                        </div>
                        <p>Change Account Balance</p>
                    </div>
                    <div class="card-body">
                        <?php
                        $overview = $holdingService->getOverview($user->id);
                        ?>
                        <p class="card-text">Count: {{ count($overview) }} </p>
                        <table class="table table-bordered table-striped table-white w-auto">
                            <thead>
                                <tr>
                                    <th style="width: 16.66%">Symbol</th>
                                    <th>Quantity</th>
                                    <th style="width: 20%">New Quantity</th>
                                    <th>Price</th>
                                    <th style="width: 20%">New Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($overview as $symbol => $details)
                                    <?php $symbolQty = $details['qty']; ?>
                                    <?php $price = $details['price']; ?>
                                    <tr>
                                        <td>{{ $symbol }}</td>
                                        <td class="text-right">{{ number_format($symbolQty) }}</td>
                                        <td class="text-right"><input class="form-control text-right" type="text"
                                                name="overview[{{ $symbol }}][qty]" value="{{ $symbolQty }}"
                                                autocomplete="off" />
                                        </td>
                                        <td class="text-right">{{ number_format($price, 4) }}</td>
                                        <td class="text-right"><input class="form-control text-right" type="text"
                                                name="overview[{{ $symbol }}][price]" value="{{ $price }}"
                                                autocomplete="off" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <h6>Nothing Found</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="btn-group pull-right">
                            <input type="submit" class="btn btn-primary" value="Save" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
