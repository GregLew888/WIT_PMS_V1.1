@if (session($key ?? 'status'))
<script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>    
    $(document).ready(function() {
        let message = @json(session($key ?? 'status'));
        swal({
        title: "Success",
        text: message,
        icon: "success",
    }).then(() => {
            // Reload the page after the alert is dismissed
            location.reload();
        });
    });
</script>
    {{-- <div class="alert alert-success" role="alert">
        {{ session($key ?? 'status') }}
    </div> --}}
@endif
