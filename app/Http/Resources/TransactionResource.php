<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'sender'      => new UserResource(User::find($this->payer)),
            'receiver'    => new UserResource(User::find($this->payee)),
            'value'      => $this->value,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
          ];
    }
}
