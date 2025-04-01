@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap');

        .form-control {
            border-radius: 7px;
            border: 1.5px solid #E3E6ED;
        }

        input.form-control:focus {
            box-shadow: none;
            border: 1.5px solid #E3E6ED;
            background-color: #F7F8FD;
            letter-spacing: 1px;
        }

        .btn-search {
            background-color: #5878FF !important;
            border-radius: 7px;
            padding: 9px 40px !important;
            margin: 0px 0px !important;
        }

        .btn-search:focus {
            box-shadow: none;
        }

        .text {
            font-size: 13px;
            color: #9CA1A4;
        }

        .price {
            background: #F5F8FD;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            width: 97px;
        }

        .flex-row {
            border: 1px solid #F2F2F4;
            border-radius: 10px;
            margin: 0 1px 0;
        }

        .flex-column p {
            font-size: 14px;
        }

        span.mb-2 {
            font-size: 12px;
            color: #8896BD;
        }

        h5 span {
            color: #869099;
        }

        @media screen and (max-width: 450px) {
            .card {
                display: flex;
                justify-content: center;
                text-align: center;
            }

            .price {
                border: none;
                margin: 0 auto;
            }
        }

        #suggestions {
            position: absolute;
            top: 100%;
            /* Place it right below the input group */
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            /* Set a max height for scrolling if many suggestions */
            overflow-y: auto;
            display: none;
            /* Hidden by default */
            padding: 20px;
            border-radius: 8px;
            /* Adjusts corner roundness */
        }


        /* To display the suggestions box when needed */
        #suggestions.active {
            display: block;
        }

        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent overlay */
            z-index: 9999;
            /* Ensure it is above all other elements */
            visibility: hidden;
            /* Initially hidden */
            opacity: 0;
            /* Initially transparent */
            transition: opacity 0.3s ease-in-out;
            /* Smooth show/hide transition */
        }

        .page-loader.active {
            visibility: visible;
            opacity: 1;
        }

        .loader-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent overlay */
        }

        .loader-content {
            z-index: 10000;
            /* Ensure it's above the overlay */
            text-align: center;
            color: #fff;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 6px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }


        #loader {
            border: 4px solid #ddd;
            border-top: 4px solid #344675;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            display: none;
            /* Hide by default */
            margin: auto;
            margin-left: 10px;
        }

        .highlight-text {
            font-weight: 700;
            color: #2f3e65 !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <!-- Admin -->
    <div id="page-loader" class="page-loader">
        <div class="loader-overlay"></div>
        <div class="loader-content">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </div>

    @if (auth()->user()->hasRole('client'))
        <div class="main-content">
            <div class="bg-gradient-primary pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase highlight-text mb-0">Capital Invested
                                                </h5>
                                                <span
                                                    class="h2 font-weight-bold mb-0">${{ number_format($data['account_balance'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                            </div>
                                            <!-- <div class="col-auto">
                          <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                            <i class="fas fa-chart-bar"></i>
                          </div>
                        </div> -->
                                        </div>
                                        <!-- <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span class="text-nowrap">Since last month</span>
                      </p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase highlight-text  mb-0">Cash Balance</h5>
                                                <span
                                                    class="h2 font-weight-bold mb-0">${{ number_format($data['cash_balance'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                            </div>
                                            <!-- <div class="col-auto">
                          <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                            <i class="fas fa-chart-pie"></i>
                          </div>
                        </div> -->
                                        </div>
                                        <!-- <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                        <span class="text-nowrap">Since last week</span>
                      </p> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase highlight-text mb-0">Outstanding
                                                    Balance</h5>
                                                <span
                                                    class="h2 font-weight-bold mb-0">${{ number_format($data['outstanding_balance'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                            </div>
                                            <!-- <div class="col-auto">
                          <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                            <i class="fas fa-users"></i>
                          </div>
                        </div> -->
                                        </div>
                                        <!-- <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span class="text-nowrap">Since yesterday</span>
                      </p> -->
                                    </div>
                                </div>
                            </div>
                            <div class=" col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase highlight-text  mb-0">Margin Amount
                                                </h5>
                                                <span
                                                    class="h2 font-weight-bold mb-0">${{ number_format($data['margin_amount'], 2, '.', ',') ?? number_format(0, 2, '.', ',') }}</span>
                                            </div>
                                            <!-- <div class="col-auto">
                          <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                            <i class="fas fa-percent"></i>
                          </div>
                        </div> -->
                                        </div>
                                        <!-- <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span class="text-nowrap">Since last month</span>
                      </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
        </div>
    @endif
    <div class="container d-flex justify-content-end">
        <div class="card mt-5 p-4" style="width: 450px;">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search" placeholder="Search for stocks/symbols"
                    autocomplete="off">
                <div class="input-group-append" style="border: none;">
                    <button class="btn btn-search"><i class="fas fa-search"></i></button>
                    <div id="loader" class="loader"></div>
                </div>
            </div>
            <div id="suggestions">
                <br>
                <li>No Results</li>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <div class="d-flex flex-column align-items-start">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons" id="filter-buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" id="filter-day">
                                        <input type="radio" name="filters" value="daily" data-filter="day" checked>
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">1D</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="filter-week">
                                        <input type="radio" name="filters" value="weekly" data-filter="week">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">1W</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="filter-month">
                                        <input type="radio" name="filters" value="monthly" data-filter="month">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">1M</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="filter-year">
                                        <input type="radio" name="filters" value="yearly" data-filter="year">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">1Y</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                </div>

                                <div class="mt-2"> <!-- Add margin for spacing -->
                                    <h2 class="card-title">Performance</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons"
                                id="symbol-buttons">
                                @foreach ($symbols as $key => $symbol)
                                    <label
                                        class="btn btn-sm btn-primary btn-simple @if ($key == 0) active @endif"
                                        id="{{ $key }}">
                                        <input type="radio" name="symbols" value="{{ $key }}"
                                            @if ($key == 0) checked @endif>
                                        <span
                                            class="d-none d-sm-block d-md-block d-lg-block d-xl-block">{{ $symbol }}</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">{{ array_key_first($digital_data) }} </h5>
                    <h3 class="card-title"><i class="tim-icons icon-money-coins text-primary"></i></h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLinePurple"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">{{ array_key_first(array_slice($digital_data, 1)) }}</h5>
                    <h3 class="card-title"><i class="tim-icons icon-map-big text-success"></i></h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLineGreen"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Comparison</h5>
                    <h3 class="card-title"><i class="tim-icons icon-sound-wave text-info"></i></h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="CountryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
            let months = @json($months);
            let data0 = @json($data0);
            let data1 = @json($data1);
            let data2 = @json($data2);

            // digital
            let digital_keys = @json($digital_keys);
            let digital_values = @json($digital_values);
            // digital single
            let digital_data = @json($digital_data);
            console.log(months);
            demo.initDashboardPageCharts(months, data0, data1, data2, digital_keys, digital_values, digital_data);
        });
    </script>

    <!-- search feature -->
    <script>
        function makeUrl(template, id) {
            let host = "{{ url('/') }}/";
            return host + template.replace(/{id}/g, id);
        }
        // Debounce function to avoid sending AJAX requests too often
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }
        $(document).ready(function() {
            const searchInput = $('#search');
            const suggestions = $('#suggestions');
            $('#search').on('input', debounce(function() {
                const query = $(this).val();
                $('#loader').show();
                if (query.length > 0) {
                    $.ajax({
                        url: '/search',
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#loader').hide();
                            suggestions.empty();
                            let count = (response.results.length);

                            suggestions.append(
                                `<span class="text mb-4">${count} Search Results</span>`
                                );
                            if (count > 0) {
                                suggestions.addClass('active'); // Or show suggestions

                                response.results.forEach(suggestion => {
                                    console.log(suggestion);
                                    suggestions.append(`

                    <a href="${makeUrl('home?q={id}', suggestion['1. symbol'])}">
                    <div class="d-flex flex-row justify-content-between mb-1">
                      <div class="d-flex flex-column p-3"><p class="mb-1">${suggestion['2. name']}</p> <small class="text-muted">${suggestion['3. type']}</small>
                      </div>
                      <div class="price pt-3 pl-3">
                        <span class="mb-2">${suggestion['1. symbol']}</span>
                        <h5>${suggestion['8. currency']}</h5>
                      </div>
                    </div>
                    </a>`);
                                });
                            } else {
                                suggestions.append('<br><li>No Results</li>');
                            }
                        },
                        error: function() {
                            console.error("Error fetching suggestions");
                            $('#loader').hide();
                        }
                    });
                } else {
                    $('#suggestions').empty();
                    $('#loader').hide();
                    suggestions.removeClass('active'); // Or hide suggestions
                }
            }, 500)); // Debounce delay in milliseconds
            // Show suggestions on focus
            searchInput.on('focus', function() {
                suggestions.addClass('active'); // Or show suggestions
            });

            // Hide suggestions on blur
            searchInput.on('blur', function() {
                suggestions.removeClass('active'); // Or hide suggestions
            });
            suggestions.on('mousedown', 'a', function(e) {
                e.preventDefault(); // Prevent default blur behavior
                const href = $(this).attr('href');
                window.location.href = href; // Manually redirect to the link
            });
        });
    </script>
    <!-- search feature end -->

    <script>
        $(document).ready(function() {
            // $('#filter-buttons label').on('click', function () {
            //     // Remove active class from all buttons and add to the clicked button
            //     $('#filter-buttons label').removeClass('active');
            //     $(this).addClass('active');

            //     // Get the filter key from the clicked button
            //     const filter = $(this).find('input').data('filter');


            //     // Extract query parameters from the URL
            //     const queryParams = new URLSearchParams(window.location.search);
            //     console.log(queryParams);

            //     // Add the filter key to the query parameters
            //     queryParams.set('filter', filter);

            //     // Make AJAX request to fetch filtered data
            //     fetchFilteredData(queryParams.toString());
            // });
            function fetchFilteredData(filterType) {
                showPageLoader(); // Show loader while fetching data
                $.ajax({
                    url: '/home',
                    method: 'GET',
                    data: filterType,
                    success: function(response) {
                        hidePageLoader(); // Hide loader
                        // Update the chart with new data from the response
                        updateChart(response);
                    },
                    error: function(err) {
                        hidePageLoader(); // Ensure loader is hidden on error
                        console.error("Error fetching data:", err);
                    }
                });
            }

            function updateChart(response) {
                console.log('herer');
                demo.initDashboardPageCharts(response.months, response.data0, response.data1, response.data2,
                    response.digital_keys, response.digital_values, response.digital_data);
                console.log('herer 22');
            }

            function showPageLoader() {
                $('#page-loader').addClass('active');
            }

            // Function to hide the loader
            function hidePageLoader() {
                $('#page-loader').removeClass('active');
            }
        });
    </script>
@endpush
