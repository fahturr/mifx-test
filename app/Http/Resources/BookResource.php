<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total = 0;
        $count = 0;

        foreach ($this->reviews as $review) {
            $count++;
            $total += $review->review;
        }

        if ($count != 0) $total = $total / $count;

        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'description' => $this->description,
            'published_year' => $this->published_year,
            'authors' => $this->authors,
            'review' => [
                'avg' => round($total),
                'count' => $count,
            ],
        ];
    }
}
