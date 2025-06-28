@extends('layouts.app', ['page' => __('Create Ticket'), 'pageSlug' => 'createTickets'])
@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Add Ticket') }}</h5>
                </div>
                <form method="post" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                            @csrf

                            @include('alerts.success')
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label>{{ _('Title') }}</label>
                                    <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ _('Ticket title') }}" value="{{ old('title') }}">
                                    @include('alerts.feedback', ['field' => 'title'])
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label>{{ _('Description') }}</label>
                                    <input type="text" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ _('Ticket description') }}" value="{{ old('description') }}">
                                    @include('alerts.feedback', ['field' => 'description'])
                                </div>

                                <div class=" mt-5 form-group{{ $errors->has('media') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tim-icons icon-camera-18"></i>
                                        </div>
                                    </div>
                                <label for="formFileLg" class="form-label" style="font-size:large">Add photos</label>
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="files[]" accept="image/*" multiple>
                                </div>     
                              
                            <!-- <div class="form-check form-check-inline">
                                <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }} mr-5">
                                    <label>{{ _('Year of Publication') }}</label>
                                    <input type="date" name="start_date" class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date')}}">
                                    @include('alerts.feedback', ['field' => 'start_date'])
                                </div>
                   
                            </div>

                            <div class="form-group{{ $errors->has('students') ? ' has-danger' : '' }} col-6">
                                <label>{{ _('Students') }}</label>
                                <div class="multi-select"> 
                                    <select id="students" name="students[]" placeholder="Select upto 5 students" multiple>
                                    </select> 
                                </div>
                                    @if ($errors->has('students'))
                                        <span class="invalid-feedback" role="alert" style="display:inline">{{ $errors->first('students') }}</span>
                                    @endif
                            </div> -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-success">{{ _('Add Ticket') }}</button>
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

                $('#normalize').selectize({placeholder : 'Select Year'});
        
            });
        </script>
    @endpush
@endsection
