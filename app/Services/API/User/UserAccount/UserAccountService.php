<?php

namespace App\Services\API\User\UserAccount;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

class UserAccountService extends BaseService {

    public function updateProfile(User $user, array $data): array
    {

        $user->name = $data['name'];

        if (isset($data['new_password']) <> null) {
            if (Hash::check($data['old_password'], $user->password) == false) {
                return $this->error(__('alert.old_password_incorrect'), 400);
            }
            $user->password = bcrypt($data['new_password']);
        }

        $user->save();
        return $this->success($user, __('alert.profile_updated'));

    }

}
