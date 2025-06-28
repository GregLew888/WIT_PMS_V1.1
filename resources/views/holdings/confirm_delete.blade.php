<!-- Delete Warning Modal -->
<div class="modal modal-danger fade" id="deleteHodlingModel" tabindex="-1" role="dialog" aria-labelledby="Delete"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="holdingLabel">Delete Holding <span
                        class="holding_transaction_holder"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('DELETE')
                    <input id="id" name="id" type="hidden" />
                    <input name="confirm" type="hidden" value="1" />
                    <h5 class="text-center">Are you sure you want to delete this Holding?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-danger">Yes, Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>
        function confirmHoldingDelete(holdingId) {

            $.get('/transaction/' + holdingId + '/lookup', function(holding) {
                console.log(holding);


                let holdingForm = $("#deleteHodlingModel").find("form");

                $("#deleteHodlingModel").find('.holding_transaction_holder').html("#" + holding.transaction_no);

                holdingForm.attr('action', '/holdings/' + holdingId);
                holdingForm.find("#id").val(holdingId)
                $('#deleteHodlingModel').modal('show');
            });
        }
    </script>
@endpush
