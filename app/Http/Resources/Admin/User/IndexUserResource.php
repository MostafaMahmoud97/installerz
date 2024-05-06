<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexUserResource extends JsonResource
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
            "company_name" => $this->company_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "subdomain" => $this->subdomain,
            "is_active" => $this->is_active,
            "is_publish" => $this->is_publish,
            "logo" => $logo
        ];
    }
}
