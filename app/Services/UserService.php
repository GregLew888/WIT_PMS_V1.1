<?php
namespace App\Services;

use App\Http\Requests\Common\PaginatedRequest;
use App\Http\Requests\Common\RecordRequest;
use App\Models\User;
use App\Traits\Helpers;
use App\Enums\Roles;

class UserService {

    use Helpers;

    public function getClientStats($user){
        return $this->getStats( $user );
    }

    /**
     *
     */
    public function getStats($user){
        $userStats = [
            'account_balance' => $user->account_balance ?? null,
            'cash_balance' => $user->cash_balance ?? null,
            'outstanding_balance' => $user->outstanding_balance ?? null,
            'margin_amount' => $user->margin_amount ?? null,
        ];
        // Check if all values from the users table are null
        $hasUserStats = !is_null($userStats['account_balance']) ||
                        !is_null($userStats['cash_balance']) ||
                        !is_null($userStats['outstanding_balance']) ||
                        !is_null($userStats['margin_amount']);

        $stats = (object) $userStats;
        return $stats;
    }

    public function search(PaginatedRequest $request){
        $model = User::whereHas('roles', function($q){
            $q->where('name', Roles::CLIENT()->value);
        })->active();
        $keyword = $request->input('keyword');
        if( !empty($keyword) ){
            $model = $model->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('email', 'like', '%'.$keyword.'%');
        }
        $page = Min((int)$request->page, 1);
        return $model->OrderBy('name', 'desc')->paginate(20);
    }

    /**
     * Undocumented function
     *
     * @param RecordRequest $request
     * @return App\Models\User
     */
    public function findById($id){
        $model = User::with('roles')->active();
        return $model->find($id);
    }
}
