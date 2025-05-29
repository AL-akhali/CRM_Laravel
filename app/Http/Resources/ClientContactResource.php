<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'client_id'=> $this->client_id,
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'position' => $this->position,
            'created_at' => $this->created_at->toDateTimeString(),
            'contacts' => ClientContactResource::collection($this->whenLoaded('contacts')),
        ];
    }
}
