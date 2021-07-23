<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label
        ];
    }


    public function with($request): array
    {
        return [
            'message' => 'success',
            'status'  => 200,
        ];
    }
}
