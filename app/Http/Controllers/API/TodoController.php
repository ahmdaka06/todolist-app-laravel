<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Todo\TodoCreateRequest;
use App\Http\Resources\API\Todo\TodosResource;
use App\Models\Todo;
use App\Services\API\User\UserActivity\UserActivityService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $limit = ($request->has('limit') AND $request->limit <> null) ? $request->limit : 10;

        $todos = Todo::query()
            ->when($request->has('q') AND $request->q, function ($query) use ($request) {
                return $query
                    ->where('title', 'like', "%$request->q%")
                    ->orWhere('description', 'like', "%$request->q%");
            })
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return $this->sendResponse([
            'data' => TodosResource::collection($todos),
            'pagination' => [
                'total' => $todos->total(),
                'per_page' => $todos->perPage(),
                'next_page_url' => $todos->nextPageUrl(),
                'prev_page_url' => $todos->previousPageUrl(),
            ]

        ], __('general.ok'));
    }

    public function create(TodoCreateRequest $request)
    {
        $todo = new Todo();
        $todo->user_id = $request->user()->id;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->started_at = $request->started_at;
        $todo->save();

        (new UserActivityService())->create($request->user()->id, "CREATE TODO", "Create new todo : {$todo->hash}");

        return $this->sendResponse(new TodosResource($todo), __('general.ok'));
    }

    public function show(Request $request, $hash)
    {
        $todo = Todo::query()->byHash($hash)->where('user_id', $request->user()->id)->first();

        if (!$todo) {
            return $this->sendError(__('general.not_found'), [], 404);
        }

        return $this->sendResponse(new TodosResource($todo), __('general.ok'));
    }

    public function update(TodoCreateRequest $request, $hash)
    {
        $todo = Todo::query()->byHash($hash)->where('user_id', $request->user()->id)->first();

        if (!$todo) {
            return $this->sendError(__('general.not_found'), [], 404);
        }

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->started_at = $request->started_at;
        $todo->save();

        (new UserActivityService())->create($request->user()->id, "UPDATE TODO", "Update todo : {$todo->hash}");

        return $this->sendResponse(new TodosResource($todo), __('general.ok'));
    }

    public function delete(Request $request, $hash)
    {
        $todo = Todo::query()->byHash($hash)->where('user_id', $request->user()->id)->first();

        if (!$todo) {
            return $this->sendError(__('general.not_found'), [], 404);
        }

        $todo->delete();

        (new UserActivityService())->create($request->user()->id, "DELETE TODO", "Delete todo : {$hash}");

        return $this->sendResponse([], __('general.ok'));
    }



}
