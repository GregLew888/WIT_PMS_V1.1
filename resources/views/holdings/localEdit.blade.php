@extends('layouts.app', ['page' => __('Update Shipment'), 'pageSlug' => 'shipments'])
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Update Shipment') }}</h5>
                </div>
                <form method="post" action="{{ route('local.update', $shipment->id) }}">
                    <div class="card-body">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                                <input type="hidden" name="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                                <label>{{ _('Customer') }}</label>
                                <h3>{{$shipment->customer->name}}</h3>
                            </div>

                            @include('alerts.success')
                                <div class="form-group{{ $errors->has('number_of_boxes') ? ' has-danger' : '' }}">
                                    <label>{{ _('Number of boxes') }}</label>
                                    <h4>{{$shipment->number_of_boxes}}</h4>
                                </div>
                                <div class="form-group{{ $errors->has('tracking_id') ? ' has-danger' : '' }}">
                                    <label>{{ _('Tracking ID') }}</label>
                                    <h4>{{$shipment->tracking_id}}</h4>
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Status') }}</label>
                                    <select id="status" name="status">
                                        <option value=""></option>
                                        <option value="Pending"  {{ ( $shipment->status == 'Pending') ? 'selected' : '' }}>Pending</option>
                                        <option value="In Progress" {{ ( $shipment->status == 'In Progress') ? 'selected' : '' }}>In Progress</option>
                                        <option value="Shipped" {{ ( $shipment->status == 'Shipped') ? 'selected' : '' }}>Shipped</option>
                                        <option value="Returned" {{ ( $shipment->status == 'Returned') ? 'selected' : '' }}>Returned</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'status'])
                                </div>
                                <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label >{{ _('Shipping cost') }}</label>
                                    <input disabled type="number" name="cost" class="form-control{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ _('Shipping Cost') }}" value="{{ old('cost', $shipment->cost) }}">
                                    @include('alerts.feedback', ['field' => 'cost'])
                                </div>
                                <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label style="font-size: x-large;" for="paid">Settled</label>
                                    <input type="checkbox" name="paid" class="form-control{{ $errors->has('cost') ? ' is-invalid' : '' }}" value="1">
                                    @include('alerts.feedback', ['field' => 'cost'])
                                </div>

                                <!-- <div class=" mt-5 form-group{{ $errors->has('media') ? ' has-danger' : '' }}">
                                         <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tim-icons icon-camera-18"></i>
                                        </div>
                                    </div>
                                <label for="formFileLg" class="form-label" style="font-size:large">Add photos and videos</label>
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="files[]" multiple>
                                </div>                                 -->
                        </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Update Shipment') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
        @push('js')
    
            <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
            />
            <script
            src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
            ></script>
        <script>
            $(document).ready(function(){


                $('#normalize').selectize({placeholder : 'Freight Type'});
                $('#customers').selectize({placeholder : 'Select Customer'});
                $('#status').selectize({placeholder : 'Select Status'});
        
            });
        </script>
    @endpush
@endsection
