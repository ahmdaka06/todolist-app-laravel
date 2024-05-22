<?php

namespace App\Services\API\Auth;

use App\Models\User;
use App\Services\API\User\UserActivity\UserActivityService;
use App\Services\BaseService;

class AuthService extends BaseService
{
    public function __construct()
    {
        //
    }

    public function login(string $email, string $password): array
    {
        $login = User::where('email', $email)->first();

        if (!$login || !auth()->attempt([
            'email' => $email,
            'password' => $password
        ])) {
            return $this->error(__('auth.failed'), 401);
        }

        $token = $login->createToken('authToken')->plainTextToken;

        (new UserActivityService())->create($login, 'LOGIN', 'Login to the apps');

        $login->token = $token;

        return $this->success($login, __('auth.login_success'));
    }

    public function register (array $data): array
    {
        $register = new User();

        $register->name = $data['name'];
        $register->username = $data['username'];
        $register->email = $data['email'];
        $register->password = bcrypt($data['password']);
        $register->save();

        (new UserActivityService())->create($register, 'REGISTER', 'Register new account');

        return $this->success($register, __('auth.register_success'));
    }
}
