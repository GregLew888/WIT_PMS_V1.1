@extends('layouts.app', ['page' => __('Holdings'), 'pageSlug' => 'holdings'])
@inject('holdingService', 'App\Services\HoldingService')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 class="card-title">Holdings</h2>
        </div>
        <div class="col-md-6">
            @role('admin')
                <div class="pull-right">
                    <a href="{{ route('holdings.create') }}" class="btn btn-sm btn-success">Add Holding</a>
                </div>
            @endrole
            @include('alerts.success')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" action="/holdings" method="get" id="form-holding-search">
                        <input type="hidden" name="page" value="0">
                        @role('admin')
                            <input type="hidden" name="client_id" id="client_id"
                                value="@if ($clientSelected === true) {{ $client->id }} @endif">
                            <label class="mr-3" for="client_id">Client</label>
                            <select class="form-control mr-3 w-25" id="client_id_dropdown" name="client_id_dropdown"
                                placeholder="Select Client">
                                <option value="">Select Client</option>
                                @if ($clientSelected === true)
                                    <option value="{{ $client->id }}" selected>#{{ $client->id }} - {{ $client->name }}
                                    </option>
                                @endif
                            </select>
                        @endrole
                        <label class="m-3" for="keyword">Search</label>
                        <input type="text" class="form-control m-3" id="keyword" name="keyword" placeholder=""
                            value="{{ request()->get('keyword') }}">
                        @role('admin')
                            <label class="m-3" for="type">Type</label>
                            <select class="form-control m-3" id="type" name="type[]" multiple>
                                <option value="">All</option>
                                <?php
                                $statuses = $holdingService->getTransactionTypes();
                                ?>
                                @foreach ($statuses as $idx => $status)
                                    <option value="{{ $status }}" @selected(in_array($status, request()->get('type', [])))>
                                        {{ strtoupper($status) }}
                                    </option>
                                @endforeach
                            </select>
                        @endrole

                        <button type="submit" class="btn btn-primary mb-2">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{ $holdings->appends(request()->query())->links() }}
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    @include('alerts.success')
                    <div class="table-responsive">
                        <table class="table tablesorter hover" id="example">
                            <thead class=" text-primary">
                                <tr>
                                    @if (auth()->user()->hasAnyRole(['admin']))
                                        <th scope="col">Client</th>
                                    @endif
                                    <th scope="col">Transaction No.</th>
                                    <th scope="col">Symbol</th>
                                    <th scope="col">Stock Name</th>
                                    <th scope="col">Trade Date</th>
                                    <th scope="col">No. of shares</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Total Volume</th>
                                    <th scope="col">Pnl</th>
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
                                            <td><a href="{{ route('users.view', ['id' => $holding->user_id]) }}">{{ $holding->client->name }}
                                                    <p class="small text-muted">
                                                        #{{ $holding->client->id ?? '' }}
                                                        <i class="fa fa-at">{{ $holding->client->email }}</i>
                                                    </p>
                                                </a>
                                            </td>
                                        @endif
                                        <td>{{ $holding->transaction_no }}
                                        </td>
                                        <td>{{ $holding->symbol }}</td>
                                        <td>{{ $holding->stock_name }}
                                        </td>
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
                                                SETTLED
                                            @else
                                                {{ strtoupper($holding->status) }}
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
                                                <div class="btn-group">
                                                    <a class="btn btn-secondary dropdown-toggle" href="javascript:void(0)"
                                                        role="button" id="dd-menu-{{ $holding->id }}"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-cog"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-left"
                                                        aria-labelledby="dd-menu-{{ $holding->id }}">
                                                        <a href="{{ route('holdings.show', ['holding' => $holding]) }}"
                                                            class="dropdown-item" data-holdingid="{{ $holding->id }}">
                                                            View
                                                            </button>
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('holdings.edit', ['holding' => $holding]) }}"><i
                                                                class="fa fa-pencil-alt"></i> Edit</a>
                                                        <button class="dropdown-item"
                                                            onclick="confirmHoldingDelete('{{ $holding->id }}')"><i
                                                                class="fa fa-trash"></i>
                                                            Delete</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
    <td colspan="12" class="text-center py-5">
        <h5 class="text-muted">No Transactions Available</h5>
        <p class="text-muted mb-0">
            Your portfolio currently does not have any transactions to display.
        </p>
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
    {{ $holdings->appends(request()->query())->links() }}
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Holding Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="holding-details">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('holdings.confirm_delete')

    @push('js')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {

                //deletion
                let route = "{{ route('holdings.index') }}/";
                $('#exampleModal').on('show.bs.modal', function(event) {
                    let holdingId = $(event.relatedTarget).data('holdingid');
                    $('#deleteholding').prop('action', route + holdingId);
                })
                //deletion

                $('#exampleModalLong').on('show.bs.modal', function(event) {
                    let holdingId = $(event.relatedTarget).data('holdingid');
                    $("#exampleModalLongTitle").html("Holding Details - " + holdingId);
                    $('#holding-details').html("<h1><i class='fa fa-spinner fa-spin'></i> Loading</h1>");
                    $.get("/holdings/" + holdingId, {
                        "ajax": true,
                        "rd": Math.random()
                    }, function(response) {
                        $('#holding-details').html(response);
                    });
                })
            });

            function formatClientOptions(client) {
                if (!client.id) {
                    return client.text;
                }
                var $state = $(
                    '<div># ' + client.id + ' ' + client.name + ' <p> <i class="fa fa-at"></i> ' + client.email +
                    ', <br /><i class="fa fa-phone"></i> ' + client.phone_number + '</p></div>'
                );
                return $state;
            };

            $("#type").select2();
            $('#client_id_dropdown').select2({
                placeholder: 'Select Client',
                templateResult: formatClientOptions,
                ajax: {
                    url: '/lookup/clients',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                let client = {
                                    ...item
                                };
                                client.text = "#" + item.id + " - " + item.name;
                                return client;
                            })
                        };
                    },
                    cache: false
                }
            });
            $('#client_id_dropdown').on("select2:select", function(e) {
                let selected = e.params.data;
                $("#form-holding-search").find("#client_id").val(selected.id);
            });

            $("#form-holding-search").submit(function(event) {

                //console.log($("#form-holding-search").serialize());
            });
        </script>
    @endpush
@endsection
