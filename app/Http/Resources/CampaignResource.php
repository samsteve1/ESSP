<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'daily_budget_formatted' => $this->daily_budget_formatted,
            'daily_budget_amount' => $this->daily_budget_amount,
            'total_budget_formatted' => $this->total_budget_formatted,
            'creatives' => CreativeResource::collection($this->creatives),
            'created_at' => $this->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a'),
            'updated_at' => $this->updated_at->isoFormat('MMMM Do YYYY, h:mm:ss a'),
            'from' => $this->from->isoFormat('MMMM Do YYYY, h:mm:ss a'),
            'to' => $this->to->isoFormat('MMMM Do YYYY, h:mm:ss a'),
        ];
    }
}
