<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\UserActivity;
use App\Services\API\Auth\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(LoginRequest $request)
    {
        $loginService = (new AuthService())->login($request->email, $request->password);

        return $this->sendResponse($loginService['data'], $loginService['message']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        UserActivity::create([
            'user_id' => $request->user()->id,
            'action' => 'LOGOUT',
            'description' => 'Logout from the apps',
            'ip_address' => $request->ip()
        ]);

        return $this->sendResponse([], __('auth.logout_success'));
    }
}
