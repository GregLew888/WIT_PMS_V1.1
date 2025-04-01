@extends('layouts.app', ['page' => __('Create Holding'), 'pageSlug' => 'holdings'])
@section('content')
    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Add Holding') }}</h5>
                </div>
                <form method="post" action="{{ route('holdings.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                            @csrf
                            
                            
                            <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                                <input type="hidden" name="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                                <label>{{ _('Customer') }}</label>
                                <select id="customers" name="user_id">
                                    <option value=""></option>
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->id}} -{{$customer->name}}</option>
                                @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'user_id'])
                            </div>

                            @include('alerts.success')
                                <div class="form-group{{ $errors->has('number_of_boxes') ? ' has-danger' : '' }}">
                                    <label>{{ _('Number of boxes') }}</label>
                                    <input type="text" name="number_of_boxes" class="form-control{{ $errors->has('number_of_boxes') ? ' is-invalid' : '' }}" placeholder="{{ _('Number of boxes') }}" value="{{ old('number_of_boxes') }}">
                                    @include('alerts.feedback', ['field' => 'number_of_boxes'])
                                </div>
                                <div class="form-group{{ $errors->has('tracking_id') ? ' has-danger' : '' }}">
                                    <label>{{ _('Tracking ID') }}</label>
                                    <input type="text" name="tracking_id" class="form-control{{ $errors->has('tracking_id') ? ' is-invalid' : '' }}" placeholder="{{ _('Local Tracking ID') }}" value="{{ old('tracking_id') }}">
                                    @include('alerts.feedback', ['field' => 'tracking_id'])
                                </div>
                                
                                <div class="form-group{{ $errors->has('freight_type') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="freight_type" class="form-control{{ $errors->has('freight_type') ? ' is-invalid' : '' }}">

                                    <label>{{ _('Freight') }}</label>
                                    <select id="freight_type" name="freight_type">
                                        <option value=""></option>
                                        <option value="Air">Air</option>
                                        <option value="Sea">Sea</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'freight_type'])
                                </div>
                                <div class="form-check form-check-inline">
                                    <div class="form-group{{ $errors->has('kg') ? ' has-danger' : '' }} mr-5 unit kg-input d-none">
                                        <label>{{ _('In Kg') }} (Price/kg={{$setting->per_kg_sell}})</label>
                                        <input type="text" name="kg" class="form-control{{ $errors->has('kg') ? ' is-invalid' : '' }}" placeholder="{{ _('Kilograms') }}"  value="{{ old('kg')}}">
                                        @include('alerts.feedback', ['field' => 'kg'])
                                    </div>
                                    <div class="form-group{{ $errors->has('cbm') ? ' has-danger' : '' }} mr-5 unit cbm-input d-none">
                                        <label>{{ _('In CBM') }} (Price/cbm={{$setting->per_cbm_sell}})</label>
                                        <input type="text" name="cbm" class="form-control{{ $errors->has('cbm') ? ' is-invalid' : '' }}" placeholder="{{ _('CBM') }}" value="{{ old('cbm')}}">
                                        @include('alerts.feedback', ['field' => 'cbm'])
                                    </div>
                    
                                </div>
                                <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                    <label>{{ _('Shipping price') }}</label>
                                    <input readonly type="number" id="price" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ _('Shipping price') }}" value="{{ old('price') }}">
                                    @include('alerts.feedback', ['field' => 'price'])
                                </div>
                                <input type="hidden" name="cost" id="cost">
                                <div class=" mt-5 form-group{{ $errors->has('media') ? ' has-danger' : '' }}">
                                         <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tim-icons icon-camera-18"></i>
                                        </div>
                                    </div>
                                <label for="formFileLg" class="form-label" style="font-size:large">Add photos and videos</label>
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="files[]" accept="image/*" multiple>
                                </div>                                
                        </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Add Holding') }}</button>
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


                $('#freight_type').selectize({placeholder : 'Freight Type'});
                $('#customers').selectize({placeholder : 'Select Customer'});

                $('#freight_type').change(function () {
                    let type = $(this).val();
                    if (type == 'Air') {
                        $('.kg-input').removeClass('d-none');
                        $('.cbm-input').addClass('d-none');
                    } else {
                        $('.kg-input').addClass('d-none');
                        $('.cbm-input').removeClass('d-none');
                    }
                });

                $('#freight_type').change(function () {
                    let type = $(this).val();
                    if (type == 'Air') {
                        $('.kg-input').removeClass('d-none');
                        $('.cbm-input').addClass('d-none');
                        $('#price').val(0);
                        $('#cost').val(0);
                        $('.unit').val(0);
                    } else {
                        $('.kg-input').addClass('d-none');
                        $('.cbm-input').removeClass('d-none');
                        $('#price').val(0);
                        $('#cost').val(0);
                        $('.unit').val(0);
                    }
                });

                $(".unit").on("input", function(e) {
                    let price = 0;
                    let cost = 0;
                    let value =  $(e.target).val();
                    let type = $('#freight_type').val();
                    if (type == 'Air') {
                        price = '{{$setting->per_kg_sell}}';
                        cost = '{{$setting->per_kg_cost}}';
                    } else {
                        price = '{{$setting->per_cbm_sell}}';
                        cost = '{{$setting->per_cbm_cost}}';
                    }
                    price = price * value;
                    cost = cost * value;

                    $('#price').val(price);
                    $('#cost').val(cost);

                });
        
            });
        </script>
    @endpush
@endsection
