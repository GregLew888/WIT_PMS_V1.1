@inject('userService', 'App\Services\UserService')
<?php
$userStats = $userService->getStats($user);
?>
<div class="card client-card">
    <div class="card-header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h4 class="card-title">
                    @if ($show_user_info)
                        #{{ $user->id }} - {{ $user->name }}
                    @endif
                    @role('admin')
                        <div class="btn-toolbar contact-toolbar pull-right">
                            <div class="btn-group btn-group-sm">
                                @if ($show_user_info)
                                    <a class="btn btn-small" href="{{ route('users.view', ['id' => $user->id]) }}">View</a>
                                @endif
                                <a class="btn btn-small" href="{{ route('users.edit', ['user' => $user]) }}">Edit</a>
                                <a class="btn btn-small" href="{{ route('users.edit-stats', ['user' => $user]) }}">Stats</a>
                            </div>
                        </div>
                    @endrole
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-user-overview">
            <thead>
                <tr>
                    <th class="w-40">Capital Invested</th>
                    <td class="w-60">{{ number_format($userStats->account_balance, 2) }}</td>
                </tr>
                <tr>
                    <th>Cash Balance</th>
                    <td>{{ number_format($userStats->cash_balance, 2) }}</td>
                </tr>
                <tr>
                    <th>Outstanding balance</th>
                    <td>{{ number_format($userStats->outstanding_balance, 2) }}</td>
                </tr>
                <tr>
                    <th>Margin amount</th>
                    <td>{{ number_format($userStats->margin_amount, 2) }}</td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-footer text-muted">
        @if ($show_user_info)
            <i class="fa fa-at"></i> {{ $user->email }} </br>
            <i class="fa fa-phone"></i> {{ $user->phone_number }}
        @endif
    </div>
</div>
