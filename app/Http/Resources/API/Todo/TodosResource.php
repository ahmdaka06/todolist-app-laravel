<?php

namespace App\Http\Resources\API\Todo;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hash' => $this->hash,
            'title' => $this->title,
            'description' => $this->description,
            'status' => [
                'text' => $this->status,
                'color' => Todo::STATUS_COLOR[$this->status] ?? '#DEDCDC',
            ],
            'started_at' => [
                'date' => $this->started_at->toDayDateTimeString(),
                'diff' => $this->started_at->diffForHumans(),
            ],
            'created_at' => [
                'date' => $this->created_at->toDayDateTimeString(),
                'diff' => $this->created_at->diffForHumans(),
            ]
        ];
    }
}
