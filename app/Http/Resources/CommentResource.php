<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user' => $this->whenLoaded('user', fn () => $this->user),
            'can' => [
                'delete' => ($request->user()?->can('delete', $this->resource)) || ($request->session()->get('guest_key') === $this->guest_key),
            ],
        ];
    }
}
