<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "job" => $this->job->name,
            "date" => $this->date,
            "shift" => $this->shift,
            "description" => $this->description,
            "status" => $this->status,
            "user" => [
                'name' => $this->user->name,
                'is_admin' => $this->user->is_admin
            ]
        ];
    }
}
