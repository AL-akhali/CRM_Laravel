<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'client_id'   => $this->client_id,
            'type'        => $this->type,
            'description' => $this->description,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
