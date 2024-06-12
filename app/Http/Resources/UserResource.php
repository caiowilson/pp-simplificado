<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'document'      => $this->document,
            'name'          => $this->name,
            'email'         => $this->email,
            'balance'       => $this->balance,
            'roles'         => $this->roles->pluck('name'),
            'created_at'    => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
