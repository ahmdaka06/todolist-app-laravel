<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Account\AccountUpdateRequest;
use App\Http\Resources\API\Account\Activity\AccountActivitiesResource;
use App\Models\UserActivity;
use App\Services\API\User\UserAccount\UserAccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function profile(Request $request)
    {
        return $this->sendResponse($request->user(), __('general.ok'));
    }

    public function activities(Request $request)
    {
        $limit = ($request->has('limit') AND $request->limit) ? $request->limit : 10;

        $activities = UserActivity::query()
            ->when($request->has('q') AND $request->q, function ($query) use ($request) {
                return $query
                    ->where('action', $request->q)
                    ->orWhere('description', $request->q);
            })
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return $this->sendResponse([
            'data' => AccountActivitiesResource::collection($activities),
            'pagination' => [
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
                'next_page_url' => $activities->nextPageUrl(),
                'prev_page_url' => $activities->previousPageUrl(),
            ]

        ], __('general.ok'));
    }

    public function update(AccountUpdateRequest $request)
    {
        $user = $request->user();

        $userAccountService = (new UserAccountService())->updateProfile($user, $request->all());

        if ($userAccountService['status'] == false) {
            return $this->sendError($userAccountService['message'], [], $userAccountService['code']);
        }

        return $this->sendResponse($userAccountService['data'], $userAccountService['message']);
    }
}
