<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Support\FiscalYear
 */
class FiscalYearResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->name,
        ];
    }
}
