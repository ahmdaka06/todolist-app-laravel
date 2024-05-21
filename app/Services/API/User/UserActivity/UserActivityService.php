<?php

namespace App\Services\API\User\UserActivity;

use App\Models\UserActivity;

class UserActivityService {

    public function create($userId, $action, $description = null): UserActivity
    {
        $userActivity = new UserActivity();
        $userActivity->user_id = $userId;
        $userActivity->action = $action;
        $userActivity->description = $description;
        $userActivity->ip_address = request()->ip();
        $userActivity->save();

        return $userActivity;
    }

}
