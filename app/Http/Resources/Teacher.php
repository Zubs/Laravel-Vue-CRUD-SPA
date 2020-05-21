<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Teacher extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }

    public function with($request) {
        return [
            'author' => 'Zubair Idris Aweda',
            'verion' => '1.0.0',
            'author_url' => url('https://www.github.com/Zubs')
        ];
    }
}
