<?php

namespace App\Http\Resources\User\SocialMedia;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexSocialMedia extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $logo = "";
        if ($this->media){
            $logo = $this->media->file_path;
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "link" => $this->pivot->link,
            "logo" => $logo
        ];
    }
}
