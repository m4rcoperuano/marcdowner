<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'unparsed_markdown' => $this->unparsed_markdown,
            'title' => $this->title,
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
