function loadRealtimeTransaction() {
    $("#realtime-transaction-feed").block({message: 'Refreshing Transactions'});
    $.get('/transaction/realtime', {
        'rd': Math.random()
    }, function(data) {
        $("#realtime-transaction-feed").html(data);
        $("#btn-refresh-transaction").click(loadRealtimeTransaction);
    });
}
