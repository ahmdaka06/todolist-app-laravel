<?php

namespace App\Services\API\User\UserActivity;

use App\Models\User;
use App\Models\UserActivity;
use App\Notifications\PushNotification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserActivityService {

    public function create(User $user, $action, $description = null): UserActivity
    {
        $userActivity = new UserActivity();
        $userActivity->user_id = $user->id;
        $userActivity->action = $action;
        $userActivity->description = $description;
        $userActivity->ip_address = request()->ip();
        $userActivity->save();

        if (!in_array($action, ['REGISTER', 'LOGOUT'])) {
            if ($user->device_token <> null) {

                $message = CloudMessage::fromArray([
                    'notification' => [
                        'title' => 'Todo Apps',
                        'body' => $description,
                        'image' => url('logo.png')

                    ],
                    'token' => $user->device_token
                ]);

                Firebase::messaging()->send($message);
            }
        }

        return $userActivity;
    }

}
