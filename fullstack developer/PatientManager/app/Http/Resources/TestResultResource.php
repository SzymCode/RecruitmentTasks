<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'orderId' => $this->getOrderId(),
            'name' => $this->getTestName(),
            'value' => $this->getTestValue(),
            'reference' => $this->getTestReference(),
        ];
    }
}
