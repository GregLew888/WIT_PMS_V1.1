<?php
namespace App\Services;

use App\Http\Requests\Common\PaginatedRequest;
use App\Http\Requests\Common\RecordRequest;
use App\Models\User;
use App\Traits\Helpers;
use App\Enums\Roles;

class UserService {

    use Helpers;
    /**
     *
     */
    public function getStats($user){
        return $this->stats($user);
    }

    public function search(PaginatedRequest $request){
        $model = User::whereHas('roles', function($q){
            $q->where('name', Roles::CLIENT()->value);
        })->active();

        if( !empty($request->keyword) ){
            $model = $model->where('name', 'like', '%'.$request->keyword.'%')
            ->orWhere('email', 'like', '%'.$request->keyword.'%');
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
