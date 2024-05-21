<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Services\API\Auth\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(RegisterRequest $request)
    {
        $registerService = (new AuthService())->register($request->all());

        return $this->sendResponse($registerService['data'], $registerService['message']);

    }
}
