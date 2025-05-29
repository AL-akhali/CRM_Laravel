<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientNoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'client_id'  => $this->client_id,
            'user_id'    => $this->user_id,
            'content'    => $this->content,
            'visibility' => $this->visibility,
            'created_at' => $this->created_at->toDateTimeString(),

            // روابط ذات علاقة (اختياري)
            'user'       => $this->whenLoaded('user', function() {
                return [
                    'id'   => $this->user->id,
                    'name' => $this->user->name,
                    'email'=> $this->user->email,
                ];
            }),
        ];
    }
}
