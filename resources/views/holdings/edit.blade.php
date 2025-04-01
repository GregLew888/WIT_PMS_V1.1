@extends('layouts.app', ['page' => __('Create Holding'), 'pageSlug' => 'holdings'])
@inject('holdingService', 'App\Services\HoldingService')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Please Fix Following Errors</h4>
        </div>
    @endif
    <form method="post" action="{{ route('transaction.change', ['id' => $holding->id]) }}">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="title">Edit Holding # {{ $holding->id }}</h3>
                    </div>
                    <input type="hidden" name="id" value="{{ $holding->id }}">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                            <label>{{ _('Customer') }}</label>
                            <select id="customers" name="user_id">
                                <option value=""></option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if ($holding->user_id == $customer->id) selected @endif>
                                        {{ $customer->id }} -{{ $customer->name }}
                                        [{{ $customer->email }}]</option>
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'user_id'])
                        </div>
                        <div class="form-group{{ $errors->has('transaction_no') ? ' has-danger' : '' }}">
                            <label>{{ _('Transaction No.') }}</label>
                            <input type="text" name="transaction_no"
                                class="form-control{{ $errors->has('transaction_no') ? ' is-invalid' : '' }}"
                                placeholder="{{ _('Transaction No.') }}"
                                value="{{ old('transaction_no', $holding->transaction_no) }}">
                            @include('alerts.feedback', ['field' => 'transaction_no'])
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('symbol') ? ' has-danger' : '' }}">
                                    <label>{{ _('Symbol') }}</label>
                                    <input type="text" name="symbol"
                                        class="form-control{{ $errors->has('symbol') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Symbol') }}" value="{{ old('symbol', $holding->symbol) }}">
                                    @include('alerts.feedback', ['field' => 'symbol'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('stock_name') ? ' has-danger' : '' }}">
                                    <label>{{ _('Stock Name') }}</label>
                                    <input type="text" name="stock_name"
                                        class="form-control{{ $errors->has('stock_name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Name') }}"
                                        value="{{ old('stock_name', $holding->stock_name) }}">
                                    @include('alerts.feedback', ['field' => 'stock_name'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group{{ $errors->has('trade_date') ? ' has-danger' : '' }}">
                                    <label>{{ _('Trade Date') }}</label>
                                    <input type="date" name="trade_date"
                                        class="form-control{{ $errors->has('trade_date') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Name') }}"
                                        value="{{ old('trade_date', now()->format('Y-m-d')) }}">
                                    @include('alerts.feedback', ['field' => 'trade_date'])
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group{{ $errors->has('no_of_shares_old') ? ' has-danger' : '' }} no_of_shares-input">
                                    <label>{{ _('No. of shares') }}</label>
                                    <input type="number" step="any" name="no_of_shares" id="no_of_shares"
                                        class="form-control{{ $errors->has('no_of_shares') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Shares') }}"
                                        value="{{ old('no_of_shares', $holding->no_of_shares) }}">
                                    @include('alerts.feedback', ['field' => 'no_of_shares_old'])
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group{{ $errors->has('unit_price') ? ' has-danger' : '' }} unit cbm-input">
                                    <label>{{ _('Unit Price') }} </label>
                                    <input type="number" step="any" name="unit_price" id="unit_price"
                                        class="form-control{{ $errors->has('unit_price') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Unit Price') }}"
                                        value="{{ old('unit_price', $holding->unit_price) }}">
                                    @include('alerts.feedback', ['field' => 'unit_price'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label>{{ _('Transaction Type') }}</label>
                                    <?php
                                    $statuses = $holdingService->getTransactionTypes();
                                    ?>
                                    <select id="type" class="form-select" name="type">
                                        <option value=""></option>
                                        @foreach ($statuses as $key => $status)
                                            <option value="{{ $status }}"
                                                @if ($holding->type == $status) selected @endif>{{ strtoupper($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'type'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('purchase') ? ' has-danger' : '' }}">
                                    <label>{{ _('Cost') }}</label>
                                    <input type="number" id="purchase" step="any" name="purchase"
                                        class="form-control{{ $errors->has('purchase') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Purchase') }}"
                                        value="{{ old('purchase', $holding->purchase) }}">
                                    @include('alerts.feedback', ['field' => 'purchase'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('total') ? ' has-danger' : '' }}">
                                    <label>{{ _('Total') }}</label>
                                    <input readonly type="number" id="total" step="any" name="total"
                                        class="form-control{{ $errors->has('total') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Total') }}" value="{{ old('total', $holding->total) }}">
                                    @include('alerts.feedback', ['field' => 'total'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('profit_loss') ? ' has-danger' : '' }}">
                                    <label>{{ _('Transaction PnL') }}</label>
                                    <input type="number" id="profit_loss" step="any" name="profit_loss"
                                        class="form-control{{ $errors->has('profit_loss') ? ' is-invalid' : '' }}"
                                        placeholder="{{ _('Transaction PnL') }}"
                                        value="{{ old('profit_loss', $holding->profit_loss) }}">
                                    @include('alerts.feedback', ['field' => 'profit_loss'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Save') }}</button>

                        <div class="pull-right btn-group">
                            <a href="{{ route('holdings.index') }}"
                                class="btn btn-fill btn-light">{{ _('Back to Holdings') }}</a>
                            <a href="{{ route('users.view', [
                                'id' => $holding->user_id,
                            ]) }}"
                                class="btn btn-fill btn-light">{{ _('Back to Customer') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    @push('js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                $('#type').selectize({
                    placeholder: 'Transaction Type'
                });
                $('#customers').selectize({
                    placeholder: 'Select Client'
                });

                $("#unit_price, #no_of_shares").on("input", function(e) {
                    let unitPrice = $("#unit_price").val();
                    let no_of_shares = $("#no_of_shares").val();
                    let totalPrice = 0;
                    totalPrice = no_of_shares * unitPrice;
                    totalPrice = (Math.round(totalPrice * 100) / 100).toFixed(2);
                    $('#total').val(totalPrice);
                    console.log("WHO AMI ", this, totalPrice);
                });
            });
        </script>
    @endpush
@endsection
