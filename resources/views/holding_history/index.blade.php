@inject('historyService', 'App\Services\HoldingHistoryService')
<div class="row">
    <div class="col-md-12">
        <?php
        $history = $historyService->getAll($holding->id);
        ?>
        @foreach ($history as $item)
            <div class="card">
                <div class="card-body">
                    <p>Status Changed to <strong>{{ strtoupper($item->new_status == 'paid' ? 'settled' : $item->new_status) }}</strong> from
                        <strong>{{ strtoupper($item->old_status == 'paid' ? 'settled' : $item->old_status) }}</strong> by <i class="fa fa-user"></i>
                        {{ !empty($item->user) ? $item->user->name : 'Admin' }} on
                        {{ $item->created_at->format('Y-m-d') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
