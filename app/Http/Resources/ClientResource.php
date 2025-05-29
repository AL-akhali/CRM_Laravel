<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'type'     => $this->type,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'industry' => $this->industry,
            'address'  => $this->address,
            'status'   => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            // علاقات (اختياري: حسب الحاجة)
            'contacts'   => ClientContactResource::collection($this->whenLoaded('contacts')),
            'notes'      => ClientNoteResource::collection($this->whenLoaded('notes')),
            'activities' => ClientActivityResource::collection($this->whenLoaded('activities')),
            'tags'       => $this->tags->pluck('name'), // مثال على التاجات
        ];
    }
}
