<?php

namespace App\Http\Resources\API\Account\Activity;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountActivitiesResource extends JsonResource
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
            'action' => $this->action,
            'description' => $this->description,
            'ip_address' => $this->ip_address,
            'created_at' => [
                'date' =>  Carbon::parse($this->created_at)->toDayDateTimeString(),
                'diff' => Carbon::parse($this->created_at)->diffForHumans(),
            ],
        ];
    }
}
