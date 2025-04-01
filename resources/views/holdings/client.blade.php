@extends('layouts.app', ['page' => __('Holdings'), 'pageSlug' => 'holdings'])
@inject('holdingService', 'App\Services\HoldingService')
@inject('userService', 'App\Services\UserService')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="card-title">Portfolio Holdings</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="realtime-marketfeed">
            @include('widgets.holdings.realtime-overview', ['user' => auth()->user()])
        </div>
    </div>

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
    @push('js')
        <script src="{{ asset('white') }}/js/realtimefeed.js"></script>
        <script>
            function onFeedLoad() {
                $("#btn-refresh-feed").click(loadRealtimeFeed);
                setInterval(() => {
                    loadRealtimeFeed();
                }, 1000 * 120);
            }
            $(function() {
                onFeedLoad();
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

            $("#form-holding-search").submit(function(event) {});
        </script>
    @endpush
@endsection
